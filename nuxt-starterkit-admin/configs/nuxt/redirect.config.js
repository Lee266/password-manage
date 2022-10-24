export default [
  { from: '^/$', to: '/dashboard' },
  { from: '^/user$', to: '/user/list' },
  { from: '^/admin$', to: '/admin/list' },
]
