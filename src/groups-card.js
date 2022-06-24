let $store = null;

document.addEventListener('alpine:init', () => {
  /**
   * Create a data store to share data between components.
   */
  Alpine.store('groupsCard', {
    groups: [],
    coach: null,
    card: null
  })
  $store = Alpine.store('groupsCard');

  /**
   * The groups card component
   */
  Alpine.data('groups_card', ({groups, coach, card}) => {

    //Hydrate the store on init
    $store.groups = groups
    $store.coach = coach
    $store.card = card

    return {
      coach: $store.coach, //Just putting this here to allow us to view our store in Alpine DevTools
      groups: $store.groups,
      init() {
        console.log($store.groups, $store.coach, $store.card)
      }
    }
  })
})
