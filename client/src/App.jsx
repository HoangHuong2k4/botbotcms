import { BrowserRouter, Routes, Route, NavLink } from 'react-router-dom'
import { Toaster } from 'react-hot-toast'
import {
  LayoutDashboard, Users, UsersRound, FileText,
  Clock, ClipboardList, Send, Menu, X, Radio
} from 'lucide-react'
import { useState } from 'react'

import Dashboard from './pages/Dashboard'
import Accounts from './pages/Accounts'
import Groups from './pages/Groups'
import Templates from './pages/Templates'
import Scheduler from './pages/Scheduler'
import Logs from './pages/Logs'

const navItems = [
  { to: '/', icon: LayoutDashboard, label: 'Dashboard' },
  { to: '/accounts', icon: Users, label: 'Tài khoản' },
  { to: '/groups', icon: UsersRound, label: 'Nhóm mục tiêu' },
  { to: '/templates', icon: FileText, label: 'Kịch bản' },
  { to: '/scheduler', icon: Clock, label: 'Lịch gửi tin' },
  { to: '/logs', icon: ClipboardList, label: 'Nhật ký' },
]

function Sidebar({ open, setOpen }) {
  return (
    <>
      {/* Overlay mobile */}
      {open && (
        <div
          className="fixed inset-0 bg-black/60 z-20 lg:hidden"
          onClick={() => setOpen(false)}
        />
      )}

      <aside className={`
        fixed top-0 left-0 h-full w-64 bg-gray-900 border-r border-gray-800 z-30 transition-transform duration-300
        ${open ? 'translate-x-0' : '-translate-x-full'}
        lg:translate-x-0 lg:static lg:z-auto
      `}>
        {/* Logo */}
        <div className="flex items-center gap-3 p-5 border-b border-gray-800">
          <div className="bg-blue-600 rounded-lg p-2">
            <Radio size={20} className="text-white" />
          </div>
          <div>
            <h1 className="font-bold text-white leading-tight">TeleBroadcast</h1>
            <p className="text-xs text-gray-400">Hub v1.0</p>
          </div>
          <button
            className="ml-auto lg:hidden text-gray-400 hover:text-white"
            onClick={() => setOpen(false)}
          >
            <X size={20} />
          </button>
        </div>

        {/* Nav */}
        <nav className="p-3 space-y-1">
          {navItems.map(item => (
            <NavLink
              key={item.to}
              to={item.to}
              end={item.to === '/'}
              onClick={() => setOpen(false)}
              className={({ isActive }) =>
                `flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                ${isActive
                  ? 'bg-blue-600/20 text-blue-400 border border-blue-600/30'
                  : 'text-gray-400 hover:text-white hover:bg-gray-800'
                }`
              }
            >
              <item.icon size={18} />
              {item.label}
            </NavLink>
          ))}
        </nav>

        {/* Footer */}
        <div className="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800">
          <p className="text-xs text-gray-500 text-center">
            © 2024 TeleBroadcast Hub
          </p>
        </div>
      </aside>
    </>
  )
}

export default function App() {
  const [sidebarOpen, setSidebarOpen] = useState(false)

  return (
    <BrowserRouter>
      <div className="flex h-screen overflow-hidden">
        <Sidebar open={sidebarOpen} setOpen={setSidebarOpen} />

        {/* Main content */}
        <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
          {/* Top bar mobile */}
          <header className="lg:hidden flex items-center gap-3 p-4 bg-gray-900 border-b border-gray-800">
            <button
              onClick={() => setSidebarOpen(true)}
              className="text-gray-400 hover:text-white"
            >
              <Menu size={22} />
            </button>
            <div className="flex items-center gap-2">
              <Radio size={18} className="text-blue-400" />
              <span className="font-bold text-white text-sm">TeleBroadcast Hub</span>
            </div>
          </header>

          {/* Page content */}
          <main className="flex-1 overflow-auto p-6">
            <Routes>
              <Route path="/" element={<Dashboard />} />
              <Route path="/accounts" element={<Accounts />} />
              <Route path="/groups" element={<Groups />} />
              <Route path="/templates" element={<Templates />} />
              <Route path="/scheduler" element={<Scheduler />} />
              <Route path="/logs" element={<Logs />} />
            </Routes>
          </main>
        </div>
      </div>

      <Toaster
        position="top-right"
        toastOptions={{
          style: {
            background: '#1f2937',
            color: '#f3f4f6',
            border: '1px solid #374151',
          },
        }}
      />
    </BrowserRouter>
  )
}
