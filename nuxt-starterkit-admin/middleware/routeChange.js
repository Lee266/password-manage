const closeSideBarPageTransition = ({ store }) => {
  store.commit('sidebar/setRevealed', false)
}

export default (context) => {
  closeSideBarPageTransition(context)
}
