import os
import glob

replacements = {
    'bg-black/50': 'bg-white',
    'border-white/10': 'border-slate-200',
    'bg-white/5': 'bg-slate-50',
    'border-white/5': 'border-slate-100',
    'text-white': 'text-slate-900',
    'text-slate-400': 'text-slate-500',
    'text-slate-300': 'text-slate-600',
    'text-primary': 'text-blue-600',
    'bg-primary': 'bg-orange-500',
    'bg-primary/20': 'bg-orange-100',
    'bg-primary/10': 'bg-orange-50',
    'hover:bg-primary/90': 'hover:bg-orange-600',
    'hover:bg-primary': 'hover:bg-orange-500',
    'hover:text-primary': 'hover:text-orange-500',
    'glass-panel': 'bg-white rounded-2xl border border-slate-200 shadow-sm',
    'border-primary': 'border-orange-500',
    'ring-primary': 'ring-orange-500',
    'text-slate-500': 'text-slate-400'
}

files = glob.glob('src/app/**/*.tsx', recursive=True)
for f in files:
    if f in ['src/app/layout.tsx', 'src/app/page.tsx']:
        continue
    with open(f, 'r') as file:
        content = file.read()
    
    for old, new in replacements.items():
        content = content.replace(old, new)
        
    with open(f, 'w') as file:
        file.write(content)

print("Fixed theme in all pages")
