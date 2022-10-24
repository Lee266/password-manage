import { sidebarServerInit } from './sidebar'
import { tableServerInit } from './table'

export const actions = {
  nuxtServerInit(store, context) {
    // Run the sidebar server init
    sidebarServerInit(store, context)

    tableServerInit(store, context)
  },
}
