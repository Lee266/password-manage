const logListDefault = {
  id: true,
  name: true,
  email: true,
  activity: true,
  detail: true,
  ipaddress: true,
  accessTime: true,
}

export const state = () => ({
  logListColumn: { ...logListDefault },
})

export const mutations = {
  setLogListColumn(state, columns) {
    state.logListColumn = { ...columns }
  },

  toggleLogListColumn(state, columnName) {
    state.logListColumn[columnName] = !state.logListColumn[columnName]
    this.$cookies.set('logListColumn', state.logListColumn)
  },
}

export const serverInit = ({ commit }, app) => {
  const logListColumn = app.$cookies.get('logListColumn') ?? logListDefault
  commit('table/setLogListColumn', logListColumn)
}
