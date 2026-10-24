import { useEffect, useState, useRef, useCallback } from 'react'
import {
  Plus, Trash2, Edit2, Eye, Image, ToggleLeft, ToggleRight,
  Sparkles, X, AlertCircle, CheckCircle,
  Bold, Italic, Underline, Strikethrough, Code, Quote, Smile, EyeOff,
  Download, Link, CheckCircle2
} from 'lucide-react'
import api from '../utils/api'
import toast from 'react-hot-toast'

// ─── Import từ Telegram Modal ────────────────────────────────────────────
function ImportFromTelegramModal({ onImport, onClose }) {
  const [link, setLink] = useState('')
  const [loading, setLoading] = useState(false)
  const [result, setResult] = useState(null)

  const handleFetch = async (e) => {
    e.preventDefault()
    if (!link.trim()) return
    try {
      setLoading(true)
      setResult(null)
      const res = await api.post('/import/from-link', { link: link.trim() })
      setResult(res.data)
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleUse = () => {
    onImport(result.html)
    onClose()
    toast.success('Đã import nội dung!')
  }

  return (
    <div className="fixed inset-0 bg-black/80 z-[60] flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-green-700/40 rounded-xl w-full max-w-xl p-6 shadow-2xl">
        <div className="flex items-center justify-between mb-4">
          <h3 className="font-semibold text-white flex items-center gap-2">
            <Download size={18} className="text-green-400" />
            Import từ Telegram
          </h3>
          <button onClick={onClose} className="text-gray-400 hover:text-white"><X size={18} /></button>
        </div>

        <div className="bg-gray-800/60 border border-gray-700 rounded-lg p-3 mb-4 text-xs text-gray-400 space-y-1">
          <p>📌 <strong className="text-gray-300">Cách 1:</strong> Copy link tin nhắn từ Telegram (chuột phải → "Copy Message Link")</p>
          <p>📌 <strong className="text-gray-300">Cách 2:</strong> Mở tin nhắn trên Telegram Web → copy URL trên thanh địa chỉ</p>
          <p className="text-green-400">✅ Userbot sẽ tự fetch và giữ nguyên toàn bộ định dạng + custom emoji</p>
        </div>

        <form onSubmit={handleFetch} className="space-y-3">
          <div>
            <label className="label">Link tin nhắn Telegram</label>
            <div className="flex gap-2">
              <input
                className="input flex-1"
                placeholder="https://t.me/channel/123 hoặc https://t.me/c/1234/456"
                value={link}
                onChange={e => setLink(e.target.value)}
                autoFocus
              />
              <button type="submit" disabled={loading || !link.trim()} className="btn-primary px-4">
                <Link size={16} />
                {loading ? 'Fetch...' : 'Fetch'}
              </button>
            </div>
          </div>
        </form>

        {result && (
          <div className="mt-4 space-y-3">
            {/* Stats */}
            <div className="flex flex-wrap gap-2">
              {result.stats.total_entities > 0 && (
                <span className="text-xs bg-gray-800 border border-gray-700 px-2 py-1 rounded text-gray-300">
                  {result.stats.total_entities} entities
                </span>
              )}
              {result.stats.custom_emoji > 0 && (
                <span className="text-xs bg-purple-900/30 border border-purple-700/40 px-2 py-1 rounded text-purple-300">
                  ✨ {result.stats.custom_emoji} custom emoji
                </span>
              )}
              {result.stats.bold > 0 && (
                <span className="text-xs bg-blue-900/30 border border-blue-700/40 px-2 py-1 rounded text-blue-300">
                  <strong>B</strong> {result.stats.bold} bold
                </span>
              )}
              {result.stats.spoiler > 0 && (
                <span className="text-xs bg-gray-700/50 border border-gray-600 px-2 py-1 rounded text-gray-400">
                  👁 {result.stats.spoiler} spoiler
                </span>
              )}
            </div>

            {/* HTML preview */}
            <div>
              <p className="text-xs text-gray-500 mb-1">Nội dung HTML đã convert:</p>
              <pre className="bg-gray-800 border border-gray-700 rounded-lg p-3 text-xs text-gray-300 font-mono overflow-auto max-h-40 whitespace-pre-wrap">{result.html}</pre>
            </div>

            <button
              onClick={handleUse}
              className="btn-primary w-full"
            >
              <CheckCircle2 size={16} />
              Dùng nội dung này
            </button>
          </div>
        )}
      </div>
    </div>
  )
}


// ─── Helper: insert HTML tag around selection ───────────────────────────────
function wrapSelection(textarea, openTag, closeTag) {
  const start = textarea.selectionStart
  const end = textarea.selectionEnd
  const val = textarea.value
  const selected = val.substring(start, end)
  if (!selected) return null
  const newVal = val.substring(0, start) + openTag + selected + closeTag + val.substring(end)
  return { newVal, cursor: start + openTag.length + selected.length + closeTag.length }
}

// ─── Helper: render HTML tags for preview ──────────────────────────────────
function renderPreviewHTML(text) {
  if (!text) return ''
  let html = text
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
  const tags = ['b', 'i', 'u', 's', 'code', 'blockquote', 'pre']
  tags.forEach(t => {
    html = html
      .replace(new RegExp(`&lt;${t}&gt;`, 'g'), `<${t}>`)
      .replace(new RegExp(`&lt;/${t}&gt;`, 'g'), `</${t}>`)
  })
  html = html
    .replace(/&lt;tg-spoiler&gt;/g, '<span class="tg-spoiler">')
    .replace(/&lt;\/tg-spoiler&gt;/g, '</span>')
  html = html.replace(
    /&lt;tg-emoji emoji-id=&quot;(\d+)&quot;&gt;([\s\S]*?)&lt;\/tg-emoji&gt;/g,
    '<span class="tg-emoji-preview" title="Custom Emoji: $1">$2</span>'
  )
  html = html.replace(/\n/g, '<br/>')
  return html
}

// ─── Custom Emoji Dialog ────────────────────────────────────────────────────
function EmojiIdDialog({ onInsert, onClose }) {
  const [raw, setRaw] = useState('')
  const [parsed, setParsed] = useState([])
  const [fallback, setFallback] = useState('⭐')

  const parseIds = (text) => {
    const ids = new Set()
    const patterns = [/\[(\d{15,})\]/g, /(?<!\d)(\d{15,})(?!\d)/g, /emoji-id="(\d+)"/g]
    for (const re of patterns) {
      let m; while ((m = re.exec(text)) !== null) ids.add(m[1])
    }
    return [...ids]
  }

  useEffect(() => { setParsed(parseIds(raw)) }, [raw])

  const handleInsert = (id) => {
    onInsert(`<tg-emoji emoji-id="${id}">${fallback}</tg-emoji>`)
  }
  const handleInsertAll = () => {
    onInsert(parsed.map(id => `<tg-emoji emoji-id="${id}">${fallback}</tg-emoji>`).join(' '))
    onClose()
  }

  return (
    <div className="fixed inset-0 bg-black/80 z-[60] flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-purple-700/50 rounded-xl w-full max-w-lg p-6 shadow-2xl">
        <div className="flex items-center justify-between mb-4">
          <h3 className="font-semibold text-white flex items-center gap-2">
            <span className="text-xl">✨</span> Custom Emoji Premium
          </h3>
          <button onClick={onClose} className="text-gray-400 hover:text-white"><X size={18} /></button>
        </div>
        <div className="space-y-4">
          <div>
            <label className="label">Dán ID emoji hoặc đoạn text CMS</label>
            <textarea
              className="input h-32 font-mono text-xs resize-none"
              placeholder={"Dán ID dạng:\n5384215120169682553\n[5386505875336744038]\nHoặc paste cả đoạn CMS có nhiều ID..."}
              value={raw}
              onChange={e => setRaw(e.target.value)}
              autoFocus
            />
            <p className="text-xs text-gray-500 mt-1">Hỗ trợ: ID thô, dạng [ID], hoặc paste cả đoạn CMS</p>
          </div>
          <div>
            <label className="label">Ký tự fallback hiển thị</label>
            <input
              className="input"
              placeholder="⭐"
              value={fallback}
              onChange={e => setFallback(e.target.value || '⭐')}
            />
            <p className="text-xs text-gray-500 mt-1">Emoji/ký tự thay thế khi không hỗ trợ custom emoji</p>
          </div>
          {parsed.length > 0 && (
            <div>
              <div className="flex items-center justify-between mb-2">
                <p className="text-sm text-green-400">✅ Phát hiện {parsed.length} custom emoji ID</p>
                <button onClick={handleInsertAll} className="btn-primary text-xs py-1 px-3">Chèn tất cả</button>
              </div>
              <div className="bg-gray-800 rounded-lg p-3 space-y-1 max-h-40 overflow-auto">
                {parsed.map(id => (
                  <div key={id} className="flex items-center justify-between gap-2 text-xs">
                    <span className="font-mono text-purple-300 truncate">ID: {id}</span>
                    <button
                      onClick={() => { handleInsert(id); onClose() }}
                      className="btn-secondary py-0.5 px-2 text-xs flex-shrink-0"
                    >
                      Chèn
                    </button>
                  </div>
                ))}
              </div>
            </div>
          )}
          {raw && parsed.length === 0 && (
            <p className="text-sm text-yellow-400">⚠️ Không tìm thấy ID hợp lệ (cần ≥15 chữ số)</p>
          )}
        </div>
      </div>
    </div>
  )
}

// ─── Formatting Toolbar ─────────────────────────────────────────────────────
function FormatToolbar({ textareaRef, onChange }) {
  const [showEmojiDialog, setShowEmojiDialog] = useState(false)

  const applyFormat = useCallback((openTag, closeTag) => {
    const ta = textareaRef.current
    if (!ta) return
    const result = wrapSelection(ta, openTag, closeTag)
    if (!result) return toast('Hãy bôi đen text trước', { icon: '👆' })
    onChange(result.newVal)
    requestAnimationFrame(() => {
      ta.focus()
      ta.setSelectionRange(result.cursor, result.cursor)
    })
  }, [textareaRef, onChange])

  const insertAtCursor = useCallback((text) => {
    const ta = textareaRef.current
    if (!ta) return
    const start = ta.selectionStart
    const newVal = ta.value.substring(0, start) + text + ta.value.substring(start)
    onChange(newVal)
    requestAnimationFrame(() => {
      ta.focus()
      ta.setSelectionRange(start + text.length, start + text.length)
    })
  }, [textareaRef, onChange])

  const btns = [
    { icon: <Bold size={14} />, label: 'Bold', open: '<b>', close: '</b>' },
    { icon: <Italic size={14} />, label: 'Italic', open: '<i>', close: '</i>' },
    { icon: <Underline size={14} />, label: 'Underline', open: '<u>', close: '</u>' },
    { icon: <Strikethrough size={14} />, label: 'Strikethrough', open: '<s>', close: '</s>' },
    { icon: <EyeOff size={14} />, label: 'Spoiler', open: '<tg-spoiler>', close: '</tg-spoiler>' },
    { icon: <Code size={14} />, label: 'Code', open: '<code>', close: '</code>' },
    { icon: <Quote size={14} />, label: 'Blockquote', open: '<blockquote>', close: '</blockquote>' },
  ]

  return (
    <>
      <div className="flex items-center gap-1 flex-wrap bg-gray-800/80 border border-gray-700 rounded-t-lg px-2 py-1.5">
        {btns.map(b => (
          <button
            key={b.label}
            type="button"
            title={b.label}
            onClick={() => applyFormat(b.open, b.close)}
            className="p-1.5 rounded text-gray-400 hover:text-white hover:bg-gray-700 transition-colors"
          >
            {b.icon}
          </button>
        ))}
        <div className="w-px h-5 bg-gray-700 mx-1" />
        <button
          type="button"
          title="Custom Emoji Premium"
          onClick={() => setShowEmojiDialog(true)}
          className="flex items-center gap-1 px-2 py-1 rounded text-purple-400 hover:text-purple-300 hover:bg-purple-900/30 transition-colors text-xs font-medium"
        >
          <Smile size={14} />
          <span>Custom Emoji</span>
          <span className="text-[10px] bg-purple-700/40 text-purple-300 px-1 rounded">✨</span>
        </button>
        <div className="ml-auto text-xs text-gray-600 hidden sm:block">Bôi đen → chọn định dạng</div>
      </div>
      {showEmojiDialog && (
        <EmojiIdDialog
          onInsert={insertAtCursor}
          onClose={() => setShowEmojiDialog(false)}
        />
      )}
    </>
  )
}

// ─── Spintax Preview Modal ──────────────────────────────────────────────────
function SpintaxPreviewModal({ content, onClose }) {
  const [previews, setPreviews] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    api.post('/templates/preview-spintax', { content })
      .then(res => setPreviews(res.data.previews))
      .catch(err => toast.error(err.message))
      .finally(() => setLoading(false))
  }, [content])

  return (
    <div className="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
      <div className="bg-gray-900 border border-gray-800 rounded-xl w-full max-w-lg p-6 max-h-[80vh] overflow-auto">
        <div className="flex items-center justify-between mb-4">
          <h2 className="font-semibold text-white flex items-center gap-2">
            <Sparkles size={18} className="text-yellow-400" />
            Xem trước biến thể Spintax
          </h2>
          <button onClick={onClose} className="text-gray-400 hover:text-white">
            <X size={20} />
          </button>
        </div>
        {loading ? (
          <p className="text-gray-400 text-center py-8">Đang tạo biến thể...</p>
        ) : (
          <div className="space-y-3">
            {previews.map((p, i) => (
              <div key={i} className="bg-gray-800 border border-gray-700 rounded-lg p-4">
                <div className="text-xs text-gray-500 mb-2">Biến thể {i + 1}</div>
                <div
                  className="text-gray-100 text-sm whitespace-pre-wrap telegram-preview"
                  dangerouslySetInnerHTML={{ __html: renderPreviewHTML(p) }}
                />
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  )
}

// ─── Template Modal ─────────────────────────────────────────────────────────
function TemplateModal({ template, onClose, onSuccess }) {
  const isEdit = !!template
  const [form, setForm] = useState({
    name: template?.name || '',
    content: template?.content || '',
    is_active: template?.is_active ?? 1,
  })
  const [imageFile, setImageFile] = useState(null)
  const [imagePreview, setImagePreview] = useState(
    template?.image_path ? `/uploads/${template.image_path}` : null
  )
  const [removeImage, setRemoveImage] = useState(false)
  const [loading, setLoading] = useState(false)
  const [showPreview, setShowPreview] = useState(false)
  const [showRawPreview, setShowRawPreview] = useState(false)
  const [showImport, setShowImport] = useState(false)
  const textareaRef = useRef(null)

  const handleImageChange = (e) => {
    const file = e.target.files[0]
    if (!file) return
    setImageFile(file)
    setImagePreview(URL.createObjectURL(file))
    setRemoveImage(false)
  }

  const handleRemoveImage = () => {
    setImageFile(null)
    setImagePreview(null)
    setRemoveImage(true)
  }

  const handleSubmit = async (e) => {
    e.preventDefault()
    if (!form.name.trim() || !form.content.trim()) {
      return toast.error('Điền đủ tên và nội dung')
    }
    try {
      setLoading(true)
      const fd = new FormData()
      fd.append('name', form.name)
      fd.append('content', form.content)
      fd.append('is_active', form.is_active ? '1' : '0')
      if (imageFile) fd.append('image', imageFile)
      if (removeImage) fd.append('remove_image', '1')

      if (isEdit) {
        await api.put(`/templates/${template.id}`, fd, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        toast.success('Đã cập nhật template')
      } else {
        await api.post('/templates', fd, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        toast.success('Đã tạo template mới')
      }
      onSuccess()
      onClose()
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  return (
    <>
      <div className="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
        <div className="bg-gray-900 border border-gray-800 rounded-xl w-full max-w-2xl p-6 max-h-[90vh] overflow-auto">
          <div className="flex items-center justify-between mb-6">
            <h2 className="font-semibold text-white text-lg">
              {isEdit ? 'Sửa kịch bản' : 'Tạo kịch bản mới'}
            </h2>
            <div className="flex items-center gap-2">
              <button
                type="button"
                onClick={() => setShowImport(true)}
                className="flex items-center gap-1.5 text-xs text-green-400 hover:text-green-300 bg-green-900/20 hover:bg-green-900/30 border border-green-800/40 px-3 py-1.5 rounded-lg transition-colors"
              >
                <Download size={14} />
                Import từ Telegram
              </button>
              <button onClick={onClose} className="text-gray-400 hover:text-white">
                <X size={20} />
              </button>
            </div>
          </div>

          <form onSubmit={handleSubmit} className="space-y-4">
            <div>
              <label className="label">Tên kịch bản</label>
              <input
                className="input"
                placeholder="Ví dụ: Quảng cáo sản phẩm A - Tháng 10"
                value={form.name}
                onChange={e => setForm(f => ({ ...f, name: e.target.value }))}
              />
            </div>

            <div>
              <div className="flex items-center justify-between mb-1">
                <label className="label mb-0">Nội dung tin nhắn</label>
                <div className="flex items-center gap-3">
                  <button
                    type="button"
                    onClick={() => setShowRawPreview(v => !v)}
                    className="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1"
                  >
                    <Eye size={13} />
                    {showRawPreview ? 'Ẩn preview' : 'Preview định dạng'}
                  </button>
                  <button
                    type="button"
                    onClick={() => form.content && setShowPreview(true)}
                    className="text-xs text-yellow-400 hover:text-yellow-300 flex items-center gap-1"
                  >
                    <Sparkles size={13} />
                    Xem trước Spintax
                  </button>
                </div>
              </div>

              {/* Formatting toolbar */}
              <FormatToolbar
                textareaRef={textareaRef}
                onChange={(val) => setForm(f => ({ ...f, content: val }))}
              />

              <textarea
                ref={textareaRef}
                className="input h-52 resize-none font-mono text-sm rounded-t-none border-t-0"
                placeholder={`{Chào|Hi|Hello} mọi người! 👋\n\n<b>Sản phẩm nổi bật:</b>\n✅ Sản phẩm A - <i>Giá tốt</i>\n✅ Sản phẩm B\n\n<tg-spoiler>🔥 Ưu đãi ẩn</tg-spoiler>\n\nLiên hệ: @username`}
                value={form.content}
                onChange={e => setForm(f => ({ ...f, content: e.target.value }))}
              />

              {/* Format preview */}
              {showRawPreview && form.content && (
                <div className="mt-2 bg-gray-800/60 border border-gray-700 rounded-lg p-3">
                  <p className="text-xs text-gray-500 mb-2">📱 Preview định dạng Telegram:</p>
                  <div
                    className="text-gray-100 text-sm whitespace-pre-wrap telegram-preview"
                    dangerouslySetInnerHTML={{ __html: renderPreviewHTML(form.content) }}
                  />
                </div>
              )}

              <div className="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs text-gray-500">
                <span>💡 <code className="bg-gray-800 px-1 rounded">{'{ Chào | Hello }'}</code> Spintax</span>
                <span>• <code className="bg-gray-800 px-1 rounded">{'<b>'}</code> Bold</span>
                <span>• <code className="bg-gray-800 px-1 rounded">{'<i>'}</code> Italic</span>
                <span>• <code className="bg-gray-800 px-1 rounded">{'<u>'}</code> Underline</span>
                <span>• <code className="bg-gray-800 px-1 rounded">{'<tg-spoiler>'}</code> Ẩn</span>
              </div>
            </div>

            {/* Ảnh */}
            <div>
              <label className="label">Ảnh đính kèm (tùy chọn)</label>
              {imagePreview ? (
                <div className="relative inline-block">
                  <img
                    src={imagePreview}
                    alt="Preview"
                    className="h-32 w-auto rounded-lg border border-gray-700 object-cover"
                  />
                  <button
                    type="button"
                    onClick={handleRemoveImage}
                    className="absolute -top-2 -right-2 bg-red-600 rounded-full p-0.5 text-white"
                  >
                    <X size={14} />
                  </button>
                </div>
              ) : (
                <label className="flex items-center gap-2 cursor-pointer border border-dashed border-gray-700 rounded-lg p-4 text-gray-400 hover:border-blue-500 hover:text-blue-400 transition-colors w-fit">
                  <Image size={20} />
                  <span className="text-sm">Chọn ảnh (JPG/PNG, tối đa 50MB)</span>
                  <input type="file" accept="image/*" className="hidden" onChange={handleImageChange} />
                </label>
              )}
            </div>

            <div className="flex items-center gap-3">
              <button
                type="button"
                onClick={() => setForm(f => ({ ...f, is_active: f.is_active ? 0 : 1 }))}
              >
                {form.is_active
                  ? <ToggleRight size={24} className="text-green-400" />
                  : <ToggleLeft size={24} className="text-gray-600" />
                }
              </button>
              <span className="text-sm text-gray-300">
                {form.is_active ? 'Đang bật – sẽ được dùng khi gửi' : 'Đang tắt – bỏ qua khi gửi'}
              </span>
            </div>

            <div className="flex gap-2 pt-2">
              <button type="button" onClick={onClose} className="btn-secondary flex-1">Hủy</button>
              <button type="submit" disabled={loading} className="btn-primary flex-1">
                {loading ? 'Đang lưu...' : isEdit ? 'Cập nhật' : 'Tạo kịch bản'}
              </button>
            </div>
          </form>
        </div>
      </div>

      {showPreview && form.content && (
        <SpintaxPreviewModal content={form.content} onClose={() => setShowPreview(false)} />
      )}
      {showImport && (
        <ImportFromTelegramModal
          onImport={(html) => setForm(f => ({ ...f, content: html }))}
          onClose={() => setShowImport(false)}
        />
      )}
    </>
  )
}

// ─── Main Page ──────────────────────────────────────────────────────────────
export default function Templates() {
  const [templates, setTemplates] = useState([])
  const [loading, setLoading] = useState(true)
  const [showModal, setShowModal] = useState(false)
  const [editTemplate, setEditTemplate] = useState(null)
  const [previewContent, setPreviewContent] = useState(null)

  const fetchTemplates = async () => {
    try {
      const res = await api.get('/templates')
      setTemplates(res.data)
    } catch (err) {
      toast.error(err.message)
    } finally {
      setLoading(false)
    }
  }

  const handleDelete = async (id) => {
    if (!confirm('Xóa kịch bản này?')) return
    try {
      await api.delete(`/templates/${id}`)
      toast.success('Đã xóa')
      fetchTemplates()
    } catch (err) {
      toast.error(err.message)
    }
  }

  const handleToggle = async (tpl) => {
    try {
      await api.put(`/templates/${tpl.id}`, { is_active: !tpl.is_active })
      fetchTemplates()
    } catch (err) {
      toast.error(err.message)
    }
  }

  useEffect(() => { fetchTemplates() }, [])

  return (
    <div className="mx-auto space-y-5">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-white">Kịch bản tin nhắn</h1>
          <p className="text-sm text-gray-400 mt-1">
            {templates.filter(t => t.is_active).length} kịch bản đang bật
          </p>
        </div>
        <button onClick={() => setShowModal(true)} className="btn-primary">
          <Plus size={18} />
          Tạo kịch bản
        </button>
      </div>

      {loading ? (
        <div className="text-center py-12 text-gray-400">Đang tải...</div>
      ) : templates.length === 0 ? (
        <div className="card text-center py-12">
          <AlertCircle size={40} className="text-gray-600 mx-auto mb-3" />
          <p className="text-gray-400">Chưa có kịch bản nào</p>
          <button onClick={() => setShowModal(true)} className="btn-primary mx-auto mt-4">
            <Plus size={18} />
            Tạo kịch bản đầu tiên
          </button>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
          {templates.map(tpl => (
            <div key={tpl.id} className={`card border transition-colors ${tpl.is_active ? 'border-gray-700' : 'border-gray-800 opacity-70'}`}>
              {/* Header */}
              <div className="flex items-start justify-between mb-3">
                <div className="flex-1 min-w-0">
                  <div className="flex items-center gap-2 flex-wrap">
                    <h3 className="font-semibold text-white truncate">{tpl.name}</h3>
                    {tpl.is_active
                      ? <span className="badge-success"><CheckCircle size={11} />Đang bật</span>
                      : <span className="badge-danger">Tắt</span>
                    }
                    {tpl.image_path && (
                      <span className="badge-info"><Image size={11} />Có ảnh</span>
                    )}
                  </div>
                  <p className="text-xs text-gray-500 mt-1">
                    {new Date(tpl.created_at).toLocaleDateString('vi-VN')}
                  </p>
                </div>
              </div>

              {/* Image preview */}
              {tpl.image_path && (
                <img
                  src={`/uploads/${tpl.image_path}`}
                  alt="banner"
                  className="w-full h-24 object-cover rounded-lg mb-3 border border-gray-700"
                />
              )}

              {/* Content preview with formatting */}
              <div
                className="text-sm text-gray-300 bg-gray-800/50 rounded-lg p-3 line-clamp-4 whitespace-pre-wrap telegram-preview"
                dangerouslySetInnerHTML={{ __html: renderPreviewHTML(tpl.content) }}
              />

              {/* Actions */}
              <div className="flex items-center gap-2 mt-4 pt-3 border-t border-gray-800">
                <button
                  onClick={() => setPreviewContent(tpl.content)}
                  className="btn-secondary text-xs py-1.5 flex-1"
                >
                  <Eye size={14} />
                  Xem trước
                </button>
                <button
                  onClick={() => setEditTemplate(tpl)}
                  className="btn-secondary text-xs py-1.5 flex-1"
                >
                  <Edit2 size={14} />
                  Sửa
                </button>
                <button
                  onClick={() => handleToggle(tpl)}
                  className="text-gray-400 hover:text-green-400 transition-colors px-2"
                >
                  {tpl.is_active
                    ? <ToggleRight size={22} className="text-green-400" />
                    : <ToggleLeft size={22} className="text-gray-600" />
                  }
                </button>
                <button
                  onClick={() => handleDelete(tpl.id)}
                  className="text-gray-400 hover:text-red-400 transition-colors px-2"
                >
                  <Trash2 size={16} />
                </button>
              </div>
            </div>
          ))}
        </div>
      )}

      {(showModal || editTemplate) && (
        <TemplateModal
          template={editTemplate}
          onClose={() => { setShowModal(false); setEditTemplate(null) }}
          onSuccess={fetchTemplates}
        />
      )}

      {previewContent && (
        <SpintaxPreviewModal content={previewContent} onClose={() => setPreviewContent(null)} />
      )}
    </div>
  )
}
