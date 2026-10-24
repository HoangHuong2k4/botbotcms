import { useEffect, useState } from 'react'
import { UsersRound, Send, CheckCircle, TrendingUp, Clock, AlertCircle, RefreshCw } from 'lucide-react'
import api from '../utils/api'
import toast from 'react-hot-toast'

function StatCard({ icon: Icon, label, value, color = 'blue', sub }) {
  const colors = {
    blue: 'bg-blue-600/20 text-blue-400',
    green: 'bg-green-600/20 text-green-400',
    red: 'bg-red-600/20 text-red-400',
    yellow: 'bg-yellow-600/20 text-yellow-400',
  }
  return (
    <div className="card flex items-start gap-4">
      <div className={`p-3 rounded-xl ${colors[color]}`}>
        <Icon size={22} />
      </div>
      <div>
        <p className="text-sm text-gray-400">{label}</p>
        <p className="text-2xl font-bold text-white mt-0.5">{value}</p>
        {sub && <p className="text-xs text-gray-500 mt-1">{sub}</p>}
      </div>
    </div>
  )
}

function LogRow({ log }) {
  const statusMap = {
    success: <span className="badge-success"><CheckCircle size={11} />Thành công</span>,
    failed: <span className="badge-danger"><AlertCircle size={11} />Thất bại</span>,
    skipped: <span className="badge-warning">Bỏ qua</span>,
  }
  return (
    <tr className="border-b border-gray-800 hover:bg-gray-800/50 transition-colors">
      <td className="py-2.5 px-3 text-xs text-gray-400 whitespace-nowrap">
        {new Date(log.sent_at).toLocaleString('vi-VN')}
      </td>
      <td className="py-2.5 px-3 text-sm font-mono text-gray-200">{log.group_identifier}</td>
      <td className="py-2.5 px-3 text-xs text-gray-400">{log.template_name || '—'}</td>
      <td className="py-2.5 px-3">{statusMap[log.status] || log.status}</td>
      <td className="py-2.5 px-3 text-xs text-red-400 max-w-xs truncate">{log.error_message || ''}</td>
    </tr>
  )
}

function MiniBar({ day }) {
  const max = Math.max(day.success + day.failed, 1)
  const successPct = (day.success / max) * 100
  return (
    <div className="flex flex-col items-center gap-1 flex-1">
      <span className="text-xs text-gray-400">{day.success}</span>
      <div className="w-full bg-gray-700 rounded-full h-2">
        <div
          className="bg-blue-500 h-2 rounded-full"
          style={{ width: `${successPct}%` }}
        />
      </div>
      <span className="text-xs text-gray-500">{day.date?.slice(5)}</span>
    </div>
  )
}

export default function Dashboard() {
  const [stats, setStats] = useState(null)
  const [loading, setLoading] = useState(true)
  const [dispatching, setDispatching] = useState(false)

  const fetchStats = async () => {
    try {
      setLoading(true)
      const res = await api.get('/stats')
      setStats(res.data)
    } catch (err) {
      toast.error('Lỗi tải thống kê: ' + err.message)
    } finally {
      setLoading(false)
    }
  }

  const runNow = async () => {
    try {
      setDispatching(true)
      await api.post('/scheduler/run-now')
      toast.success('Bắt đầu gửi tin! Theo dõi trong tab Nhật ký.')
    } catch (err) {
      toast.error(err.message)
    } finally {
      setDispatching(false)
    }
  }

  useEffect(() => {
    fetchStats()
    const interval = setInterval(fetchStats, 30000)
    return () => clearInterval(interval)
  }, [])

  if (loading && !stats) {
    return (
      <div className="flex items-center justify-center h-64">
        <RefreshCw size={24} className="animate-spin text-blue-400" />
      </div>
    )
  }

  return (
    <div className="max-w-6xl mx-auto space-y-6">
      {/* Header */}
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-white">Dashboard</h1>
          <p className="text-sm text-gray-400 mt-1">Tổng quan hoạt động hệ thống</p>
        </div>
        <div className="flex gap-2">
          <button onClick={fetchStats} className="btn-secondary text-sm">
            <RefreshCw size={16} className={loading ? 'animate-spin' : ''} />
            Làm mới
          </button>
          <button onClick={runNow} disabled={dispatching} className="btn-primary text-sm">
            <Send size={16} className={dispatching ? 'animate-pulse' : ''} />
            {dispatching ? 'Đang gửi...' : 'Gửi ngay'}
          </button>
        </div>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <StatCard
          icon={UsersRound}
          label="Nhóm đang chạy"
          value={stats?.activeGroups ?? '—'}
          color="blue"
        />
        <StatCard
          icon={Send}
          label="Tin gửi hôm nay"
          value={stats?.todaySent ?? '—'}
          color="green"
        />
        <StatCard
          icon={CheckCircle}
          label="Tổng thành công"
          value={stats?.totalSuccess ?? '—'}
          color="green"
        />
        <StatCard
          icon={TrendingUp}
          label="Tỷ lệ thành công"
          value={`${stats?.successRate ?? 0}%`}
          color={stats?.successRate >= 80 ? 'green' : 'yellow'}
        />
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* 7-day chart */}
        <div className="card lg:col-span-2">
          <h2 className="font-semibold text-white mb-4 flex items-center gap-2">
            <TrendingUp size={18} className="text-blue-400" />
            Tin gửi 7 ngày qua
          </h2>
          {stats?.last7Days && stats.last7Days.length > 0 ? (
            <div className="flex items-end gap-2 h-24">
              {stats.last7Days.map((day, i) => (
                <MiniBar key={i} day={day} />
              ))}
            </div>
          ) : (
            <p className="text-gray-500 text-sm">Chưa có dữ liệu</p>
          )}
        </div>

        {/* Schedule slots */}
        <div className="card">
          <h2 className="font-semibold text-white mb-4 flex items-center gap-2">
            <Clock size={18} className="text-blue-400" />
            Khung giờ hôm nay
          </h2>
          {stats?.activeSlots?.length > 0 ? (
            <div className="space-y-2">
              {stats.activeSlots.map((slot, i) => {
                const now = new Date()
                const [h, m] = slot.split(':').map(Number)
                const slotDate = new Date()
                slotDate.setHours(h, m, 0, 0)
                const isPast = now > slotDate
                return (
                  <div key={i} className={`flex items-center gap-3 p-2.5 rounded-lg ${isPast ? 'bg-gray-800/50 opacity-60' : 'bg-blue-600/10 border border-blue-600/20'}`}>
                    <div className={`w-2 h-2 rounded-full ${isPast ? 'bg-gray-500' : 'bg-blue-400 animate-pulse'}`} />
                    <span className="font-mono font-bold text-white">{slot}</span>
                    <span className="text-xs text-gray-400 ml-auto">{isPast ? 'Đã qua' : 'Sắp tới'}</span>
                  </div>
                )
              })}
            </div>
          ) : (
            <p className="text-gray-500 text-sm">Chưa có lịch gửi</p>
          )}
        </div>
      </div>

      {/* Recent logs */}
      <div className="card">
        <h2 className="font-semibold text-white mb-4 flex items-center gap-2">
          <Clock size={18} className="text-blue-400" />
          Nhật ký gần nhất
        </h2>
        {stats?.recentLogs?.length > 0 ? (
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="text-xs text-gray-500 border-b border-gray-800">
                  <th className="text-left py-2 px-3">Thời gian</th>
                  <th className="text-left py-2 px-3">Nhóm</th>
                  <th className="text-left py-2 px-3">Template</th>
                  <th className="text-left py-2 px-3">Trạng thái</th>
                  <th className="text-left py-2 px-3">Lỗi</th>
                </tr>
              </thead>
              <tbody>
                {stats.recentLogs.map(log => <LogRow key={log.id} log={log} />)}
              </tbody>
            </table>
          </div>
        ) : (
          <p className="text-gray-500 text-sm">Chưa có nhật ký nào</p>
        )}
      </div>
    </div>
  )
}
