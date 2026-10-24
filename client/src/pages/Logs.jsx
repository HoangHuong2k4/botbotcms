import { useEffect, useState, useRef } from 'react'
import { CheckCircle, XCircle, SkipForward, RefreshCw, Trash2, Filter, Search, ChevronLeft, ChevronRight } from 'lucide-react'
import api from '../utils/api'
import toast from 'react-hot-toast'

const STATUS_LABELS = {
  success: { label: 'Thành công', icon: CheckCircle, cls: 'badge-success' },
  failed: { label: 'Thất bại', icon: XCircle, cls: 'badge-danger' },
  skipped: { label: 'Bỏ qua', icon: SkipForward, cls: 'badge-warning' },
}

export default function Logs() {
  const [logs, setLogs] = useState([])
  const [pagination, setPagination] = useState({ total: 0, page: 1, limit: 50, pages: 1 })
  const [loading, setLoading] = useState(true)
  const [autoRefresh, setAutoRefresh] = useState(true)
  const [filters, setFilters] = useState({ status: '', group: '', date: '' })
  const [page, setPage] = useState(1)
  const intervalRef = useRef(null)

  const fetchLogs = async (p = page) => {
    try {
      setLoading(true)
      const params = new URLSearchParams({
        page: p,
        limit: 50,
        ...(filters.status && { status: filters.status }),
        ...(filters.group && { group: filters.group }),
        ...(filters.date && { date: filters.date }),
      })
      const res = await api.get(`/logs?${params}`)
      setLogs(res.data)
      setPagination(res.pagination)
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleClearLogs = async () => {
    if (!confirm('Xóa toàn bộ nhật ký? Hành động này không thể hoàn tác.')) return
    try {
      await api.delete('/logs')
      toast.success('Đã xóa toàn bộ nhật ký')
      fetchLogs(1)
      setPage(1)
    } catch (err) {
      toast.error(err.message)
    }
  }

  useEffect(() => {
    fetchLogs(page)
  }, [page, filters])

  useEffect(() => {
    if (autoRefresh) {
      intervalRef.current = setInterval(() => fetchLogs(page), 8000)
    }
    return () => clearInterval(intervalRef.current)
  }, [autoRefresh, page, filters])

  const applyFilter = (key, value) => {
    setFilters(f => ({ ...f, [key]: value }))
    setPage(1)
  }

  return (
    <div className="max-w-6xl mx-auto space-y-5">
      <div className="flex items-center justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-bold text-white">Nhật ký hoạt động</h1>
          <p className="text-sm text-gray-400 mt-1">
            {pagination.total.toLocaleString()} bản ghi tổng cộng
          </p>
        </div>
        <div className="flex items-center gap-2 flex-wrap">
          <button
            onClick={() => setAutoRefresh(a => !a)}
            className={`text-xs px-3 py-1.5 rounded-lg border transition-colors flex items-center gap-1.5 ${
              autoRefresh
                ? 'bg-green-900/30 border-green-700 text-green-400'
                : 'bg-gray-800 border-gray-700 text-gray-400'
            }`}
          >
            <RefreshCw size={12} className={autoRefresh ? 'animate-spin' : ''} />
            {autoRefresh ? 'Auto refresh: ON' : 'Auto refresh: OFF'}
          </button>
          <button onClick={() => fetchLogs(page)} className="btn-secondary text-sm">
            <RefreshCw size={14} />
            Tải lại
          </button>
          <button onClick={handleClearLogs} className="btn-danger text-sm">
            <Trash2 size={14} />
            Xóa hết
          </button>
        </div>
      </div>

      {/* Filters */}
      <div className="card flex flex-wrap gap-3">
        <div className="flex items-center gap-2">
          <Filter size={15} className="text-gray-400" />
          <span className="text-sm text-gray-400">Lọc:</span>
        </div>
        <select
          className="bg-gray-800 border border-gray-700 text-sm text-gray-200 rounded-lg px-3 py-1.5 outline-none focus:ring-2 focus:ring-blue-500"
          value={filters.status}
          onChange={e => applyFilter('status', e.target.value)}
        >
          <option value="">Tất cả trạng thái</option>
          <option value="success">✅ Thành công</option>
          <option value="failed">❌ Thất bại</option>
          <option value="skipped">⏭ Bỏ qua</option>
        </select>
        <div className="flex items-center gap-1 bg-gray-800 border border-gray-700 rounded-lg px-2">
          <Search size={14} className="text-gray-400" />
          <input
            className="bg-transparent text-sm text-gray-200 py-1.5 px-1 outline-none w-36 placeholder-gray-500"
            placeholder="Tên nhóm..."
            value={filters.group}
            onChange={e => applyFilter('group', e.target.value)}
          />
        </div>
        <input
          type="date"
          className="bg-gray-800 border border-gray-700 text-sm text-gray-200 rounded-lg px-3 py-1.5 outline-none focus:ring-2 focus:ring-blue-500"
          value={filters.date}
          onChange={e => applyFilter('date', e.target.value)}
        />
        {(filters.status || filters.group || filters.date) && (
          <button
            onClick={() => { setFilters({ status: '', group: '', date: '' }); setPage(1) }}
            className="text-xs text-gray-400 hover:text-white flex items-center gap-1"
          >
            <XCircle size={14} />
            Xóa bộ lọc
          </button>
        )}
      </div>

      {/* Table */}
      <div className="card p-0 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="text-xs text-gray-500 border-b border-gray-800 bg-gray-800/50">
                <th className="text-left py-3 px-4 font-medium">Thời gian</th>
                <th className="text-left py-3 px-4 font-medium">Nhóm</th>
                <th className="text-left py-3 px-4 font-medium">Kịch bản</th>
                <th className="text-left py-3 px-4 font-medium">Trạng thái</th>
                <th className="text-left py-3 px-4 font-medium">Chi tiết lỗi</th>
              </tr>
            </thead>
            <tbody>
              {loading && logs.length === 0 ? (
                <tr>
                  <td colSpan={5} className="text-center py-12 text-gray-400">
                    <RefreshCw size={20} className="animate-spin mx-auto mb-2" />
                    Đang tải...
                  </td>
                </tr>
              ) : logs.length === 0 ? (
                <tr>
                  <td colSpan={5} className="text-center py-12 text-gray-500">
                    Chưa có nhật ký nào
                  </td>
                </tr>
              ) : (
                logs.map(log => {
                  const statusInfo = STATUS_LABELS[log.status] || { label: log.status, cls: 'badge-info' }
                  const Icon = statusInfo.icon
                  return (
                    <tr key={log.id} className="border-b border-gray-800 hover:bg-gray-800/30 transition-colors">
                      <td className="py-3 px-4 text-xs text-gray-400 whitespace-nowrap">
                        {new Date(log.sent_at).toLocaleString('vi-VN', {
                          day: '2-digit', month: '2-digit', year: 'numeric',
                          hour: '2-digit', minute: '2-digit', second: '2-digit'
                        })}
                      </td>
                      <td className="py-3 px-4">
                        <span className="font-mono text-blue-300 text-xs">{log.group_identifier}</span>
                        {log.group_title && log.group_title !== log.group_identifier && (
                          <span className="block text-gray-500 text-xs mt-0.5">{log.group_title}</span>
                        )}
                      </td>
                      <td className="py-3 px-4 text-xs text-gray-400 max-w-[150px] truncate">
                        {log.template_name || '—'}
                      </td>
                      <td className="py-3 px-4">
                        <span className={statusInfo.cls}>
                          {Icon && <Icon size={11} />}
                          {statusInfo.label}
                        </span>
                      </td>
                      <td className="py-3 px-4 text-xs text-red-400 max-w-xs">
                        {log.error_message ? (
                          <span title={log.error_message} className="cursor-help line-clamp-2">
                            {log.error_message}
                          </span>
                        ) : '—'}
                      </td>
                    </tr>
                  )
                })
              )}
            </tbody>
          </table>
        </div>

        {/* Pagination */}
        {pagination.pages > 1 && (
          <div className="flex items-center justify-between px-4 py-3 border-t border-gray-800">
            <span className="text-xs text-gray-400">
              Trang {pagination.page}/{pagination.pages} • {pagination.total} bản ghi
            </span>
            <div className="flex items-center gap-1">
              <button
                onClick={() => setPage(p => Math.max(1, p - 1))}
                disabled={page <= 1}
                className="p-1.5 rounded text-gray-400 hover:text-white hover:bg-gray-700 disabled:opacity-30"
              >
                <ChevronLeft size={16} />
              </button>
              {Array.from({ length: Math.min(5, pagination.pages) }, (_, i) => {
                const p = Math.max(1, Math.min(pagination.pages - 4, page - 2)) + i
                return (
                  <button
                    key={p}
                    onClick={() => setPage(p)}
                    className={`w-8 h-8 rounded text-xs font-medium transition-colors ${
                      p === page ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white'
                    }`}
                  >
                    {p}
                  </button>
                )
              })}
              <button
                onClick={() => setPage(p => Math.min(pagination.pages, p + 1))}
                disabled={page >= pagination.pages}
                className="p-1.5 rounded text-gray-400 hover:text-white hover:bg-gray-700 disabled:opacity-30"
              >
                <ChevronRight size={16} />
              </button>
            </div>
          </div>
        )}
      </div>
    </div>
  )
}
