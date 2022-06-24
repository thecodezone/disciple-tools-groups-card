let store = null;

document.addEventListener('alpine:init', () => {
  Alpine.store('groupsCard', {
    groups: [],
    coach: null,
    card: null
  })
  store = Alpine.store('groupsCard');

  Alpine.data('groups_card', ({groups, coach, card}) => {
    console.log('store', store)
    store.groups = groups
    store.coach = coach
    store.card = card

    return  ({
      init() {
        console.log(store.groups, store.coach, store.card)
      }
    })
  })
})
