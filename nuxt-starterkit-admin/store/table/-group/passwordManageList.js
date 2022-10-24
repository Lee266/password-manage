const passwordManageListDefault = {
  website: true,
  username: true,
  password: true,
  siteName: true,
  email: true,
  createdAt: true,
  registrationDate: true,
}

export const state = () => ({
  passwordManageListColumn: { ...passwordManageListDefault },
})

export const mutations = {
  setPasswordManageListColumn(state, columns) {
    state.passwordManageListColumn = { ...columns }
  },

  togglePasswordManageListColumn(state, columnName) {
    state.passwordManageListColumn[columnName] = !state.passwordManageListColumn[columnName]
    this.$cookies.set('passwordManageListColumn', state.passwordManageListColumn)
  },
}

export const serverInit = ({ commit }, app) => {
  const passwordManageListColumn = app.$cookies.get('passwordManageListColumn') ?? passwordManageListDefault
  commit('table/setPasswordManageListColumn', passwordManageListColumn)
}
