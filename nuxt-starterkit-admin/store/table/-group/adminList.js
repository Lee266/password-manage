const adminListDefault = {
  name: true,
  role: true,
  email: true,
  company: true,
  telpNumber: true,
  residence: true,
  registrationDate: true,
}

export const state = () => ({
  adminListColumn: { ...adminListDefault },
})

export const mutations = {
  setAdminListColumn(state, columns) {
    state.adminListColumn = { ...columns }
  },

  toggleAdminListColumn(state, columnName) {
    state.adminListColumn[columnName] = !state.adminListColumn[columnName]
    this.$cookies.set('adminListColumn', state.adminListColumn)
  },
}

export const serverInit = ({ commit }, app) => {
  const adminListColumn =
    app.$cookies.get('adminListColumn') ?? adminListDefault
  commit('table/setAdminListColumn', adminListColumn)
}
