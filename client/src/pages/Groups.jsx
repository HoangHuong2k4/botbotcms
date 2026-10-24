import { useEffect, useState } from 'react'
import { Plus, Trash2, Edit2, ToggleLeft, ToggleRight, Upload, Search, CheckSquare, Square, AlertCircle, FileText, X, Check, Play } from 'lucide-react'
import api from '../utils/api'
import toast from 'react-hot-toast'

// ─── Modal gán kịch bản cho nhóm ───────────────────────────────────────────
function AssignTemplatesModal({ group, onClose, onSuccess }) {
  const [allTemplates, setAllTemplates] = useState([])
  const [assigned, setAssigned] = useState(new Set())
  const [loading, setLoading] = useState(true)
  const [saving, setSaving] = useState(false)

  useEffect(() => {
    Promise.all([
      api.get('/templates'),
      api.get(`/groups/${group.id}/templates`),
    ]).then(([tplRes, assignedRes]) => {
      setAllTemplates(tplRes.data)
      setAssigned(new Set(assignedRes.data.map(t => t.id)))
    }).catch(err => toast.error(err.message))
      .finally(() => setLoading(false))
  }, [group.id])

  const toggle = (id) => {
    setAssigned(prev => {
      const next = new Set(prev)
      if (next.has(id)) next.delete(id)
      else next.add(id)
      return next
    })
  }

  const handleSave = async () => {
    try {
      setSaving(true)
      await api.put(`/groups/${group.id}/templates`, { template_ids: Array.from(assigned) })
      toast.success(assigned.size === 0
        ? 'Nhóm sẽ dùng tất cả kịch bản (mặc định)'
        : `Đã gán ${assigned.size} kịch bản cho nhóm`)
      onSuccess()
      onClose()
    } catch (err) {
      toast.error(err.message)
    } finally {
      setSaving(false)
    }
  }

  return (
    <div className="fixed inset-0 bg-black/75 z-50 flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-gray-700 rounded-xl w-full max-w-md p-6 shadow-2xl">
        <div className="flex items-center justify-between mb-1">
          <h2 className="font-semibold text-white flex items-center gap-2">
            <FileText size={18} className="text-blue-400" />
            Kịch bản của nhóm
          </h2>
          <button onClick={onClose} className="text-gray-400 hover:text-white"><X size={18} /></button>
        </div>
        <p className="text-xs text-gray-500 mb-4">
          <span className="font-mono text-blue-300">{group.identifier}</span>
          {' '} — Không chọn = dùng tất cả kịch bản đang bật
        </p>

        {loading ? (
          <p className="text-gray-400 text-center py-8">Đang tải...</p>
        ) : allTemplates.length === 0 ? (
          <p className="text-gray-400 text-center py-8">Chưa có kịch bản nào</p>
        ) : (
          <div className="space-y-2 max-h-72 overflow-auto pr-1">
            {allTemplates.map(tpl => (
              <button
                key={tpl.id}
                type="button"
                onClick={() => toggle(tpl.id)}
                className={`w-full flex items-start gap-3 p-3 rounded-lg border text-left transition-colors ${
                  assigned.has(tpl.id)
                    ? 'border-blue-600 bg-blue-900/20 text-white'
                    : 'border-gray-700 bg-gray-800/40 text-gray-300 hover:border-gray-600'
                }`}
              >
                <div className="mt-0.5 flex-shrink-0">
                  {assigned.has(tpl.id)
                    ? <CheckSquare size={16} className="text-blue-400" />
                    : <Square size={16} className="text-gray-500" />
                  }
                </div>
                <div className="flex-1 min-w-0">
                  <div className="flex items-center gap-2">
                    <span className="text-sm font-medium truncate">{tpl.name}</span>
                    {!tpl.is_active && (
                      <span className="text-[10px] text-red-400 bg-red-900/30 px-1.5 py-0.5 rounded">Tắt</span>
                    )}
                  </div>
                  <p className="text-xs text-gray-500 mt-0.5 line-clamp-1 font-mono">{tpl.content.substring(0, 60)}...</p>
                </div>
              </button>
            ))}
          </div>
        )}

        <div className="mt-4 pt-4 border-t border-gray-800 flex items-center justify-between gap-3">
          <p className="text-xs text-gray-500">
            {assigned.size === 0
              ? '📋 Dùng tất cả kịch bản đang bật'
              : `✅ Đã chọn ${assigned.size} kịch bản`}
          </p>
          <div className="flex gap-2">
            <button onClick={onClose} className="btn-secondary text-sm py-1.5 px-3">Hủy</button>
            <button onClick={handleSave} disabled={saving} className="btn-primary text-sm py-1.5 px-3">
              <Check size={15} />
              {saving ? 'Đang lưu...' : 'Lưu'}
            </button>
          </div>
        </div>
      </div>
    </div>
  )
}

function GroupRow({ group, selected, onToggleSelect, onToggle, onDelete, onEdit, onAssign, onRunNow }) {
  return (
    <tr className="border-b border-gray-800 hover:bg-gray-800/40 transition-colors">
      <td className="py-3 px-4 w-10">
        <button onClick={() => onToggleSelect(group.id)}>
          {selected ? <CheckSquare size={16} className="text-blue-400" /> : <Square size={16} className="text-gray-600" />}
        </button>
      </td>
      <td className="py-3 px-4 font-mono text-sm text-blue-300">{group.identifier}</td>
      <td className="py-3 px-4 text-sm text-gray-300">{group.title || '—'}</td>
      <td className="py-3 px-4">
        <button
          onClick={() => onAssign(group)}
          title="Chọn kịch bản cho nhóm này"
          className="flex items-center gap-1.5 text-xs text-gray-400 hover:text-blue-400 transition-colors bg-gray-800 hover:bg-gray-700 px-2 py-1 rounded"
        >
          <FileText size={13} />
          {group.template_count > 0
            ? <span className="text-blue-400 font-medium">{group.template_count} kịch bản</span>
            : <span>All</span>
          }
        </button>
      </td>
      <td className="py-3 px-4 text-xs text-gray-500">
        {group.last_sent_at ? new Date(group.last_sent_at).toLocaleString('vi-VN') : 'Chưa gửi'}
      </td>
      <td className="py-3 px-4">
        <button onClick={() => onToggle(group)} title={group.is_active ? 'Tắt' : 'Bật'}>
          {group.is_active ? (
            <ToggleRight size={22} className="text-green-400" />
          ) : (
            <ToggleLeft size={22} className="text-gray-600" />
          )}
        </button>
      </td>
      <td className="py-3 px-4">
        <div className="flex items-center gap-2">
          <button onClick={() => onRunNow(group)} className="text-gray-400 hover:text-green-400 transition-colors" title="Gửi kịch bản ngay">
            <Play size={15} />
          </button>
          <button onClick={() => onEdit(group)} className="text-gray-400 hover:text-blue-400 transition-colors" title="Sửa">
            <Edit2 size={15} />
          </button>
          <button onClick={() => onDelete(group.id)} className="text-gray-400 hover:text-red-400 transition-colors" title="Xóa">
            <Trash2 size={15} />
          </button>
        </div>
      </td>
    </tr>
  )
}


function BulkImportModal({ onClose, onSuccess }) {
  const [text, setText] = useState('')
  const [loading, setLoading] = useState(false)

  const handleSubmit = async (e) => {
    e.preventDefault()
    if (!text.trim()) return toast.error('Danh sách trống')
    try {
      setLoading(true)
      const res = await api.post('/groups', { bulk: text })
      toast.success(`Đã thêm ${res.added} nhóm mới`)
      onSuccess()
      onClose()
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-gray-800 rounded-xl w-full max-w-lg p-6">
        <h2 className="font-semibold text-white mb-1">Nhập nhóm hàng loạt</h2>
        <p className="text-sm text-gray-400 mb-4">Mỗi dòng 1 nhóm: @ten_nhom hoặc t.me/ten_nhom</p>
        <form onSubmit={handleSubmit} className="space-y-4">
          <textarea
            className="input h-48 resize-none font-mono text-sm"
            placeholder={"@nhom1\n@nhom2\nt.me/nhom3\nhttps://t.me/nhom4"}
            value={text}
            onChange={e => setText(e.target.value)}
            autoFocus
          />
          <div className="flex gap-2">
            <button type="button" onClick={onClose} className="btn-secondary flex-1">Hủy</button>
            <button type="submit" disabled={loading} className="btn-primary flex-1">
              <Upload size={16} />
              {loading ? 'Đang nhập...' : 'Nhập danh sách'}
            </button>
          </div>
        </form>
      </div>
    </div>
  )
}

function EditGroupModal({ group, onClose, onSuccess }) {
  const [title, setTitle] = useState(group.title || '')
  const [loading, setLoading] = useState(false)

  const handleSubmit = async (e) => {
    e.preventDefault()
    try {
      setLoading(true)
      await api.put(`/groups/${group.id}`, { title })
      toast.success('Đã cập nhật')
      onSuccess()
      onClose()
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-gray-800 rounded-xl w-full max-w-sm p-6">
        <h2 className="font-semibold text-white mb-4">Sửa nhóm</h2>
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="label">Identifier</label>
            <input className="input opacity-50" value={group.identifier} disabled />
          </div>
          <div>
            <label className="label">Tên ghi chú</label>
            <input
              className="input"
              placeholder="Tên dễ nhớ cho nhóm này"
              value={title}
              onChange={e => setTitle(e.target.value)}
              autoFocus
            />
          </div>
          <div className="flex gap-2">
            <button type="button" onClick={onClose} className="btn-secondary flex-1">Hủy</button>
            <button type="submit" disabled={loading} className="btn-primary flex-1">Lưu</button>
          </div>
        </form>
      </div>
    </div>
  )
}

export default function Groups() {
  const [groups, setGroups] = useState([])
  const [loading, setLoading] = useState(true)
  const [showBulk, setShowBulk] = useState(false)
  const [editGroup, setEditGroup] = useState(null)
  const [assignGroup, setAssignGroup] = useState(null)
  const [newIdent, setNewIdent] = useState('')
  const [search, setSearch] = useState('')
  const [selected, setSelected] = useState(new Set())

  const fetchGroups = async () => {
    try {
      const res = await api.get('/groups')
      const groups = res.data
      // Lấy số kịch bản được gán cho mỗi nhóm
      const counts = await Promise.all(
        groups.map(g =>
          api.get(`/groups/${g.id}/templates`)
            .then(r => ({ id: g.id, count: r.data.length }))
            .catch(() => ({ id: g.id, count: 0 }))
        )
      )
      const countMap = Object.fromEntries(counts.map(c => [c.id, c.count]))
      setGroups(groups.map(g => ({ ...g, template_count: countMap[g.id] || 0 })))
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleAdd = async (e) => {
    e.preventDefault()
    if (!newIdent.trim()) return
    try {
      await api.post('/groups', { identifier: newIdent.trim() })
      toast.success('Đã thêm nhóm')
      setNewIdent('')
      fetchGroups()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleToggle = async (group) => {
    try {
      await api.patch(`/groups/${group.id}/toggle`)
      fetchGroups()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleDelete = async (id) => {
    if (!confirm('Xóa nhóm này?')) return
    try {
      await api.delete(`/groups/${id}`)
      toast.success('Đã xóa')
      fetchGroups()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleDeleteSelected = async () => {
    if (selected.size === 0) return
    if (!confirm(`Xóa ${selected.size} nhóm đã chọn?`)) return
    try {
      await api.delete('/groups', { ids: Array.from(selected) })
      toast.success(`Đã xóa ${selected.size} nhóm`)
      setSelected(new Set())
      fetchGroups()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const toggleSelect = (id) => {
    setSelected(prev => {
      const next = new Set(prev)
      if (next.has(id)) next.delete(id)
      else next.add(id)
      return next
    })
  }

  const toggleSelectAll = () => {
    if (selected.size === filtered.length) {
      setSelected(new Set())
    } else {
      setSelected(new Set(filtered.map(g => g.id)))
    }
  }

  const handleRunNow = async (group) => {
    if (!window.confirm(`Bạn có chắc muốn gửi kịch bản ngay lập tức cho nhóm ${group.identifier}?`)) return
    try {
      const res = await api.post(`/scheduler/run-group/${group.id}`)
      toast.success(res.message)
    } catch (err) {
      toast.error(err.message || err.response?.data?.error || 'Có lỗi xảy ra')
    }
  }

  const filtered = groups.filter(g =>
    g.identifier.toLowerCase().includes(search.toLowerCase()) ||
    (g.title || '').toLowerCase().includes(search.toLowerCase())
  )

  const activeCount = groups.filter(g => g.is_active).length

  useEffect(() => { fetchGroups() }, [])

  return (
    <div className="mx-auto space-y-5">
      <div className="flex items-center justify-between flex-wrap gap-3">
        <div>
          <h1 className="text-2xl font-bold text-white">Nhóm mục tiêu</h1>
          <p className="text-sm text-gray-400 mt-1">
            {activeCount}/{groups.length} nhóm đang hoạt động
          </p>
        </div>
        <div className="flex gap-2">
          {selected.size > 0 && (
            <button onClick={handleDeleteSelected} className="btn-danger text-sm">
              <Trash2 size={15} />
              Xóa {selected.size} nhóm
            </button>
          )}
          <button onClick={() => setShowBulk(true)} className="btn-secondary text-sm">
            <Upload size={15} />
            Nhập hàng loạt
          </button>
        </div>
      </div>

      {/* Add single */}
      <div className="card">
        <form onSubmit={handleAdd} className="flex gap-2">
          <input
            className="input flex-1"
            placeholder="@ten_nhom hoặc t.me/ten_nhom"
            value={newIdent}
            onChange={e => setNewIdent(e.target.value)}
          />
          <button type="submit" className="btn-primary">
            <Plus size={18} />
            Thêm nhóm
          </button>
        </form>
      </div>

      {/* Search + Table */}
      <div className="card p-0 overflow-hidden">
        <div className="p-4 border-b border-gray-800 flex items-center gap-3">
          <Search size={16} className="text-gray-400" />
          <input
            className="bg-transparent text-sm text-gray-100 flex-1 outline-none placeholder-gray-500"
            placeholder="Tìm kiếm nhóm..."
            value={search}
            onChange={e => setSearch(e.target.value)}
          />
          <span className="text-xs text-gray-500">{filtered.length} nhóm</span>
        </div>

        {loading ? (
          <div className="py-12 text-center text-gray-400">Đang tải...</div>
        ) : filtered.length === 0 ? (
          <div className="py-12 text-center">
            <AlertCircle size={36} className="text-gray-600 mx-auto mb-2" />
            <p className="text-gray-400">
              {search ? 'Không tìm thấy nhóm nào' : 'Chưa có nhóm nào'}
            </p>
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="text-xs text-gray-500 border-b border-gray-800">
                  <th className="py-3 px-4 w-10">
                    <button onClick={toggleSelectAll}>
                      {selected.size === filtered.length && filtered.length > 0
                        ? <CheckSquare size={16} className="text-blue-400" />
                        : <Square size={16} className="text-gray-600" />
                      }
                    </button>
                  </th>
                  <th className="text-left py-3 px-4">Identifier</th>
                  <th className="text-left py-3 px-4">Ghi chú</th>
                  <th className="text-left py-3 px-4">Kịch bản</th>
                  <th className="text-left py-3 px-4">Gửi cuối</th>
                  <th className="text-left py-3 px-4">Trạng thái</th>
                  <th className="text-left py-3 px-4">Hành động</th>
                </tr>
              </thead>
              <tbody>
                {filtered.map(group => (
                  <GroupRow
                    key={group.id}
                    group={group}
                    selected={selected.has(group.id)}
                    onToggleSelect={toggleSelect}
                    onToggle={handleToggle}
                    onDelete={handleDelete}
                    onEdit={setEditGroup}
                    onAssign={setAssignGroup}
                    onRunNow={handleRunNow}
                  />
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>

      {showBulk && (
        <BulkImportModal onClose={() => setShowBulk(false)} onSuccess={fetchGroups} />
      )}
      {editGroup && (
        <EditGroupModal group={editGroup} onClose={() => setEditGroup(null)} onSuccess={fetchGroups} />
      )}
      {assignGroup && (
        <AssignTemplatesModal
          group={assignGroup}
          onClose={() => setAssignGroup(null)}
          onSuccess={fetchGroups}
        />
      )}
    </div>
  )
}

