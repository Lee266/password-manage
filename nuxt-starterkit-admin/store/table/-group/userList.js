const userListDefault = {
  username: true,
  email: true,
  createdAt: true,
}

export const state = () => ({
  userListColumn: { ...userListDefault },
})

export const mutations = {
  setUserListColumn(state, columns) {
    state.userListColumn = { ...columns }
  },

  toggleUserListColumn(state, columnName) {
    state.userListColumn[columnName] = !state.userListColumn[columnName]
    this.$cookies.set('userListColumn', state.userListColumn)
  },
}

export const serverInit = ({ commit }, app) => {
  const userListColumn = app.$cookies.get('userListColumn') ?? userListDefault
  commit('table/setUserListColumn', userListColumn)
}
