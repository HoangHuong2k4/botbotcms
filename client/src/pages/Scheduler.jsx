import { useEffect, useState } from 'react'
import { Clock, Plus, Trash2, Play, Square, ToggleLeft, ToggleRight, Settings, RefreshCw, Zap } from 'lucide-react'
import api from '../utils/api'
import toast from 'react-hot-toast'

export default function Scheduler() {
  const [config, setConfig] = useState({ slots: [], settings: {} })
  const [status, setStatus] = useState({ isRunning: false, currentRun: null })
  const [loading, setLoading] = useState(true)
  const [newSlot, setNewSlot] = useState('')
  const [settings, setSettings] = useState({ delay_min: 35, delay_max: 65, shuffle_groups: true })
  const [savingSettings, setSavingSettings] = useState(false)
  const [running, setRunning] = useState(false)

  const fetchConfig = async () => {
    try {
      const [configRes, statusRes] = await Promise.all([
        api.get('/scheduler/config'),
        api.get('/scheduler/status'),
      ])
      setConfig(configRes.data)
      setStatus(statusRes.data)
      setSettings({
        delay_min: parseInt(configRes.data.settings.delay_min) || 35,
        delay_max: parseInt(configRes.data.settings.delay_max) || 65,
        shuffle_groups: configRes.data.settings.shuffle_groups !== '0',
      })
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleAddSlot = async (e) => {
    e.preventDefault()
    if (!newSlot) return toast.error('Chọn giờ gửi')
    try {
      await api.post('/scheduler/config/slots', { time_slot: newSlot })
      toast.success(`Đã thêm khung giờ ${newSlot}`)
      setNewSlot('')
      fetchConfig()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleToggleSlot = async (id) => {
    try {
      await api.patch(`/scheduler/config/slots/${id}/toggle`)
      fetchConfig()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleDeleteSlot = async (id) => {
    if (!confirm('Xóa khung giờ này?')) return
    try {
      await api.delete(`/scheduler/config/slots/${id}`)
      toast.success('Đã xóa')
      fetchConfig()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleSaveSettings = async () => {
    if (settings.delay_min >= settings.delay_max) {
      return toast.error('Delay tối thiểu phải nhỏ hơn tối đa')
    }
    try {
      setSavingSettings(true)
      await api.put('/scheduler/config/settings', settings)
      toast.success('Đã lưu cài đặt')
    } catch (err) {
      toast.error(err.message)
    } finally {
      setSavingSettings(false)
    }
  }

  const handleRunNow = async () => {
    try {
      setRunning(true)
      await api.post('/scheduler/run-now')
      toast.success('Bắt đầu gửi! Xem nhật ký để theo dõi.')
      setTimeout(fetchConfig, 2000)
    } catch (err) {
      toast.error(err.message)
    } finally {
      setRunning(false)
    }
  }

  const handleStop = async () => {
    try {
      await api.post('/scheduler/stop')
      toast.success('Đã gửi lệnh dừng')
      setTimeout(fetchConfig, 1000)
    } catch (err) {
      toast.error(err.message)
    }
  }

  useEffect(() => {
    fetchConfig()
    const interval = setInterval(fetchConfig, 5000)
    return () => clearInterval(interval)
  }, [])

  return (
    <div className="max-w-4xl mx-auto space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-white">Lịch gửi tin</h1>
          <p className="text-sm text-gray-400 mt-1">Cấu hình lịch tự động và điều phối gửi tin</p>
        </div>
        <button onClick={fetchConfig} className="btn-secondary text-sm">
          <RefreshCw size={15} className={loading ? 'animate-spin' : ''} />
          Làm mới
        </button>
      </div>

      {/* Dispatcher status */}
      <div className={`card border ${status.isRunning ? 'border-green-600/40 bg-green-900/10' : 'border-gray-800'}`}>
        <div className="flex items-center justify-between flex-wrap gap-3">
          <div className="flex items-center gap-3">
            <div className={`w-3 h-3 rounded-full ${status.isRunning ? 'bg-green-400 animate-pulse' : 'bg-gray-600'}`} />
            <div>
              <h3 className="font-semibold text-white">
                {status.isRunning ? '🚀 Đang gửi tin...' : '⏹ Dispatcher chờ'}
              </h3>
              {status.currentRun && (
                <p className="text-sm text-gray-400 mt-0.5">
                  {status.currentRun.done}/{status.currentRun.total} nhóm •
                  ✅ {status.currentRun.success} •
                  ❌ {status.currentRun.fail}
                </p>
              )}
            </div>
          </div>
          <div className="flex gap-2">
            {status.isRunning ? (
              <button onClick={handleStop} className="btn-danger text-sm">
                <Square size={15} />
                Dừng ngay
              </button>
            ) : (
              <button onClick={handleRunNow} disabled={running} className="btn-success text-sm">
                <Zap size={15} />
                {running ? 'Đang khởi động...' : 'Gửi thủ công ngay'}
              </button>
            )}
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Time slots */}
        <div className="card space-y-4">
          <h2 className="font-semibold text-white flex items-center gap-2">
            <Clock size={18} className="text-blue-400" />
            Khung giờ gửi cố định
          </h2>

          {/* Add slot */}
          <form onSubmit={handleAddSlot} className="flex gap-2">
            <input
              type="time"
              className="input flex-1"
              value={newSlot}
              onChange={e => setNewSlot(e.target.value)}
            />
            <button type="submit" className="btn-primary px-3">
              <Plus size={16} />
            </button>
          </form>

          {/* Slot list */}
          <div className="space-y-2">
            {config.slots.length === 0 ? (
              <p className="text-gray-500 text-sm text-center py-4">Chưa có khung giờ nào</p>
            ) : (
              config.slots.map(slot => {
                const now = new Date()
                const [h, m] = slot.time_slot.split(':').map(Number)
                const slotDate = new Date()
                slotDate.setHours(h, m, 0, 0)
                const isPast = now > slotDate
                return (
                  <div key={slot.id} className={`flex items-center gap-3 p-3 rounded-lg border ${
                    !slot.is_active ? 'bg-gray-800/30 border-gray-700 opacity-60' :
                    isPast ? 'bg-gray-800/50 border-gray-700' :
                    'bg-blue-600/10 border-blue-600/30'
                  }`}>
                    <Clock size={16} className={slot.is_active && !isPast ? 'text-blue-400' : 'text-gray-500'} />
                    <span className="font-mono font-bold text-white flex-1">{slot.time_slot}</span>
                    {slot.is_active && !isPast && (
                      <span className="text-xs text-blue-400">Sắp tới</span>
                    )}
                    {isPast && slot.is_active && (
                      <span className="text-xs text-gray-500">Đã qua</span>
                    )}
                    <button onClick={() => handleToggleSlot(slot.id)}>
                      {slot.is_active
                        ? <ToggleRight size={20} className="text-green-400" />
                        : <ToggleLeft size={20} className="text-gray-500" />
                      }
                    </button>
                    <button
                      onClick={() => handleDeleteSlot(slot.id)}
                      className="text-gray-500 hover:text-red-400 transition-colors"
                    >
                      <Trash2 size={15} />
                    </button>
                  </div>
                )
              })
            )}
          </div>
        </div>

        {/* Settings */}
        <div className="card space-y-5">
          <h2 className="font-semibold text-white flex items-center gap-2">
            <Settings size={18} className="text-blue-400" />
            Cài đặt hành vi gửi
          </h2>

          <div>
            <label className="label">Độ trễ tối thiểu (giây)</label>
            <input
              type="number"
              min={10}
              max={300}
              className="input"
              value={settings.delay_min}
              onChange={e => setSettings(s => ({ ...s, delay_min: parseInt(e.target.value) }))}
            />
            <p className="text-xs text-gray-500 mt-1">Khuyến nghị: 35+ giây để tránh bị ban</p>
          </div>

          <div>
            <label className="label">Độ trễ tối đa (giây)</label>
            <input
              type="number"
              min={10}
              max={600}
              className="input"
              value={settings.delay_max}
              onChange={e => setSettings(s => ({ ...s, delay_max: parseInt(e.target.value) }))}
            />
            <p className="text-xs text-gray-500 mt-1">
              Delay thực tế: random trong [{settings.delay_min}s, {settings.delay_max}s]
            </p>
          </div>

          <div className="flex items-center gap-3 p-3 bg-gray-800/50 rounded-lg">
            <button onClick={() => setSettings(s => ({ ...s, shuffle_groups: !s.shuffle_groups }))}>
              {settings.shuffle_groups
                ? <ToggleRight size={22} className="text-green-400" />
                : <ToggleLeft size={22} className="text-gray-500" />
              }
            </button>
            <div>
              <p className="text-sm font-medium text-white">Đảo ngẫu nhiên thứ tự nhóm</p>
              <p className="text-xs text-gray-400">Shuffle danh sách nhóm trước mỗi lần gửi</p>
            </div>
          </div>

          <div className="bg-amber-900/20 border border-amber-800/40 rounded-lg p-3 text-xs text-amber-300">
            ⚠️ <strong>Khuyến nghị:</strong> Delay tối thiểu 35-65 giây để hạn chế nguy cơ bị FloodWait hoặc ban tài khoản.
          </div>

          <button onClick={handleSaveSettings} disabled={savingSettings} className="btn-primary w-full">
            {savingSettings ? 'Đang lưu...' : 'Lưu cài đặt'}
          </button>
        </div>
      </div>
    </div>
  )
}
