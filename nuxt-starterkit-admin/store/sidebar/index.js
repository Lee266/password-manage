import { sidebar as sidebarConfig } from '@/configs/layout'

export const state = () => ({
  // Collapsed state
  isCollapsed: false,

  // Mobile revealed state
  isRevealed: false,

  // The copyright
  copyright: 'Copyright © Grune All Rights Reserved',

  // Add the sidebar config to the state
  ...sidebarConfig,
})

export const mutations = {
  // Set the sidebar collapsed state
  setCollapsed(state, collapsed) {
    const isCollapsed = collapsed ?? true
    state.isCollapsed = isCollapsed
    this.$cookies.set('collapsed', state.isCollapsed)
  },

  // Toggle the current sidebar collapsed state
  toggleCollapsed(state) {
    state.isCollapsed = !state.isCollapsed
    this.$cookies.set('collapsed', state.isCollapsed)
  },

  // Set the sidebar revealed state
  setRevealed(state, revealed) {
    const isRevealed = revealed ?? true
    state.isRevealed = isRevealed
    this.$cookies.set('revealed', state.isRevealed)
  },

  // Toggle the current sidebar revealed state
  toggleRevealed(state) {
    state.isRevealed = !state.isRevealed
    this.$cookies.set('revealed', state.isRevealed)
  },

  // Set the sidebar copyright text
  setCopyright(state, copyright) {
    state.copyright = copyright
  },
}

// Run server side cookie checking
// If sidebar "collapsed" cookie is preset,
// commit changes based on the cookie value
export const sidebarServerInit = ({ commit }, app) => {
  // Set collapsed based on the server cookie
  const isCollapsed = app.$cookies.get('collapsed') ?? false
  commit('sidebar/setCollapsed', isCollapsed)

  // Set revealed based on the server cookie
  const isRevealed = app.$cookies.get('revealed') ?? false
  commit('sidebar/setRevealed', isRevealed)
}
