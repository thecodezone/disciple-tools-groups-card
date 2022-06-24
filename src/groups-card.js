let $store = null;

document.addEventListener('alpine:init', () => {
  /**
   * Create a data store to share data between components.
   */
  Alpine.store('groupsCard', {
    groups: [],
    coach: null,
    card: null,
    leader: null
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
      store: $store
    }
  })

  Alpine.data('leader_filter', () => {
    return {
      store: $store,
      init() {
        $.typeahead({
          input: this.$refs.filter_field,
          minLength: 0,
          accent: true,
          searchOnFocus: true,
          source: TYPEAHEADS.typeaheadContactsSource(),
          templateValue: "{{name}}",
          template: window.TYPEAHEADS.contactListRowTemplate,
          dynamic: true,
          hint: true,
          emptyTemplate: window.lodash.escape(window.wpApiShare.translations.no_records_found),
          callback: {
            onClick: function (node, a, item) {
              $store.leader = item
            }
          },
        });
      }
    }
  })
})
