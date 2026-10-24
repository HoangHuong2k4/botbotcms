import { useEffect, useState } from 'react'
import { Plus, Trash2, LogOut, Wifi, WifiOff, Clock, AlertCircle, Send, ShieldCheck } from 'lucide-react'
import api from '../utils/api'
import toast from 'react-hot-toast'

function StatusBadge({ account }) {
  if (account.status === 'connected' || account.is_online) {
    return <span className="badge-success"><Wifi size={11} />Đang kết nối</span>
  }
  if (account.status === 'flood_wait') {
    return <span className="badge-warning"><Clock size={11} />FloodWait {account.flood_wait_remaining}s</span>
  }
  return <span className="badge-danger"><WifiOff size={11} />Mất kết nối</span>
}

function AddAccountModal({ onClose, onSuccess }) {
  const [step, setStep] = useState('form') // form | otp | password
  const [form, setForm] = useState({ phone: '', api_id: '', api_hash: '' })
  const [otp, setOtp] = useState('')
  const [password, setPassword] = useState('')
  const [loading, setLoading] = useState(false)

  const handleSendOtp = async (e) => {
    e.preventDefault()
    if (!form.phone || !form.api_id || !form.api_hash) {
      return toast.error('Vui lòng điền đầy đủ thông tin')
    }
    try {
      setLoading(true)
      await api.post('/accounts/send-otp', {
        phone: form.phone,
        api_id: form.api_id,
        api_hash: form.api_hash,
      })
      toast.success('Đã gửi OTP về Telegram của bạn')
      setStep('otp')
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleVerifyOtp = async (e) => {
    e.preventDefault()
    try {
      setLoading(true)
      await api.post('/accounts/verify-otp', {
        phone: form.phone,
        code: otp,
        password: step === 'password' ? password : undefined,
      })
      toast.success('Đăng nhập thành công!')
      onSuccess()
      onClose()
    } catch (err) {
      if (err.message === 'NEED_2FA_PASSWORD') {
        toast('Tài khoản có bật 2FA, nhập mật khẩu 2FA', { icon: '🔐' })
        setStep('password')
      } else {
        toast.error(err.message)
      }
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-gray-800 rounded-xl w-full max-w-md p-6">
        <div className="flex items-center gap-3 mb-6">
          <div className="bg-blue-600/20 rounded-lg p-2">
            <ShieldCheck size={20} className="text-blue-400" />
          </div>
          <div>
            <h2 className="font-semibold text-white">
              {step === 'form' ? 'Thêm tài khoản Telegram' : step === 'otp' ? 'Nhập mã OTP' : 'Xác thực 2FA'}
            </h2>
            <p className="text-xs text-gray-400">
              {step === 'form' ? 'Bước 1: Thông tin API' : step === 'otp' ? 'Bước 2: Nhập OTP từ Telegram' : 'Bước 3: Mật khẩu 2FA'}
            </p>
          </div>
        </div>

        {step === 'form' && (
          <form onSubmit={handleSendOtp} className="space-y-4">
            <div>
              <label className="label">Số điện thoại <span className="text-gray-500">(+84...)</span></label>
              <input
                className="input"
                placeholder="+84901234567"
                value={form.phone}
                onChange={e => setForm(f => ({ ...f, phone: e.target.value }))}
              />
            </div>
            <div>
              <label className="label">API ID</label>
              <input
                className="input"
                placeholder="12345678"
                value={form.api_id}
                onChange={e => setForm(f => ({ ...f, api_id: e.target.value }))}
              />
              <p className="text-xs text-gray-500 mt-1">Lấy tại <a href="https://my.telegram.org" target="_blank" rel="noreferrer" className="text-blue-400 hover:underline">my.telegram.org</a></p>
            </div>
            <div>
              <label className="label">API Hash</label>
              <input
                className="input font-mono"
                placeholder="abc123def456..."
                value={form.api_hash}
                onChange={e => setForm(f => ({ ...f, api_hash: e.target.value }))}
              />
            </div>
            <div className="flex gap-2 pt-2">
              <button type="button" onClick={onClose} className="btn-secondary flex-1">Hủy</button>
              <button type="submit" disabled={loading} className="btn-primary flex-1">
                <Send size={16} />
                {loading ? 'Đang gửi...' : 'Gửi OTP'}
              </button>
            </div>
          </form>
        )}

        {(step === 'otp' || step === 'password') && (
          <form onSubmit={handleVerifyOtp} className="space-y-4">
            <div className="bg-blue-900/20 border border-blue-800/50 rounded-lg p-3 text-sm text-blue-300">
              📱 Kiểm tra ứng dụng Telegram trên máy hoặc điện thoại để lấy mã OTP
            </div>
            <div>
              <label className="label">Mã OTP (5-6 số)</label>
              <input
                className="input text-center text-2xl tracking-widest font-mono"
                placeholder="• • • • • •"
                maxLength={7}
                value={otp}
                onChange={e => setOtp(e.target.value.replace(/\D/g, ''))}
                autoFocus
              />
            </div>
            {step === 'password' && (
              <div>
                <label className="label">Mật khẩu 2FA</label>
                <input
                  type="password"
                  className="input"
                  placeholder="Mật khẩu xác minh 2 bước"
                  value={password}
                  onChange={e => setPassword(e.target.value)}
                  autoFocus
                />
              </div>
            )}
            <div className="flex gap-2 pt-2">
              <button type="button" onClick={() => setStep('form')} className="btn-secondary flex-1">← Quay lại</button>
              <button type="submit" disabled={loading} className="btn-primary flex-1">
                <ShieldCheck size={16} />
                {loading ? 'Đang xác thực...' : 'Xác nhận'}
              </button>
            </div>
          </form>
        )}
      </div>
    </div>
  )
}

export default function Accounts() {
  const [accounts, setAccounts] = useState([])
  const [loading, setLoading] = useState(true)
  const [showModal, setShowModal] = useState(false)

  const fetchAccounts = async () => {
    try {
      const res = await api.get('/accounts')
      setAccounts(res.data)
    } catch (err) {
      toast.error('Lỗi tải tài khoản: ' + err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleDelete = async (id) => {
    if (!confirm('Xác nhận xóa tài khoản này?')) return
    try {
      await api.delete(`/accounts/${id}`)
      toast.success('Đã xóa tài khoản')
      fetchAccounts()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleDisconnect = async (id) => {
    try {
      await api.post(`/accounts/${id}/disconnect`)
      toast.success('Đã ngắt kết nối')
      fetchAccounts()
    } catch (err) {
      toast.error(err.message)
    }
  }

  useEffect(() => {
    fetchAccounts()
    const interval = setInterval(fetchAccounts, 10000)
    return () => clearInterval(interval)
  }, [])

  return (
    <div className="max-w-4xl mx-auto space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-white">Tài khoản Telegram</h1>
          <p className="text-sm text-gray-400 mt-1">Quản lý tài khoản Userbot</p>
        </div>
        <button onClick={() => setShowModal(true)} className="btn-primary">
          <Plus size={18} />
          Thêm tài khoản
        </button>
      </div>

      {loading ? (
        <div className="card text-center py-12 text-gray-400">Đang tải...</div>
      ) : accounts.length === 0 ? (
        <div className="card text-center py-12">
          <AlertCircle size={40} className="text-gray-600 mx-auto mb-3" />
          <p className="text-gray-400">Chưa có tài khoản nào</p>
          <p className="text-gray-500 text-sm mt-1">Thêm tài khoản Telegram để bắt đầu</p>
          <button onClick={() => setShowModal(true)} className="btn-primary mx-auto mt-4">
            <Plus size={18} />
            Thêm tài khoản đầu tiên
          </button>
        </div>
      ) : (
        <div className="space-y-3">
          {accounts.map(acc => (
            <div key={acc.id} className="card flex items-center gap-4">
              <div className="w-12 h-12 bg-blue-600/20 rounded-full flex items-center justify-center flex-shrink-0">
                <span className="text-blue-400 font-bold text-lg">
                  {(acc.first_name || acc.phone)?.[0]?.toUpperCase()}
                </span>
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex items-center gap-2 flex-wrap">
                  <span className="font-semibold text-white">
                    {acc.first_name || 'Tài khoản'}
                  </span>
                  {acc.username && (
                    <span className="text-gray-400 text-sm">@{acc.username}</span>
                  )}
                  <StatusBadge account={acc} />
                </div>
                <p className="text-sm text-gray-400 mt-0.5 font-mono">{acc.phone}</p>
                <p className="text-xs text-gray-600 mt-0.5">
                  API ID: {acc.api_id} • Thêm lúc: {new Date(acc.created_at).toLocaleDateString('vi-VN')}
                </p>
              </div>
              <div className="flex items-center gap-2 flex-shrink-0">
                <button
                  onClick={() => handleDisconnect(acc.id)}
                  className="btn-secondary text-xs py-1.5 px-3"
                  title="Ngắt kết nối"
                >
                  <LogOut size={14} />
                </button>
                <button
                  onClick={() => handleDelete(acc.id)}
                  className="btn-danger text-xs py-1.5 px-3"
                  title="Xóa"
                >
                  <Trash2 size={14} />
                </button>
              </div>
            </div>
          ))}
        </div>
      )}

      {showModal && (
        <AddAccountModal
          onClose={() => setShowModal(false)}
          onSuccess={fetchAccounts}
        />
      )}
    </div>
  )
}
