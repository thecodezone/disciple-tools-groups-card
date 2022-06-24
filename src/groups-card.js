let store = null;

document.addEventListener('alpine:init', () => {
  Alpine.store('groupsCard', {
    groups: [],
    coach: null,
    card: null
  })
  store = Alpine.store('groupsCard');

  Alpine.data('groups_card', ({groups, coach, card}) => {
    store.groups = groups
    store.coach = coach
    store.card = card

    return {
      store: store,
      init() {
        console.log(store.groups, store.coach, store.card)
      }
    }
  })
})
