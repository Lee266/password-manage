import {
  state as userListState,
  mutations as userListMutations,
  serverInit as userListServerInit,
} from './-group/userList'

import {
  state as adminListState,
  mutations as adminListMutations,
  serverInit as adminListServerInit,
} from './-group/adminList'

import {
  state as logListState,
  mutations as logListMutations,
  serverInit as logListServerInit,
} from './-group/logList'

import {
  state as passwordManageListState,
  mutations as passwordManageListMutations,
  serverInit as passwordManageListServerInit,
} from './-group/passwordManageList'

export const state = () => ({
  ...userListState,
  ...adminListState,
  ...logListState,
  ...passwordManageListState,
})

export const mutations = {
  ...userListMutations,
  ...adminListMutations,
  ...logListMutations,
  ...passwordManageListMutations,
}

export const tableServerInit = (store, context) => {
  userListServerInit(store, context)
  adminListServerInit(store, context)
  logListServerInit(store, context)
  passwordManageListServerInit(store, context)
}
