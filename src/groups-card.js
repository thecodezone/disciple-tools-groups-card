let $store = null;

document.addEventListener('alpine:init', () => {
  /**
   * Create a data store to share data between components.
   */
  $store = null
  Alpine.store('groupsCard', {
    groups: [],
    group: null,
    coach: null,
    card: null,
    leader: null,
    error: null,
    setGroup(group) {
      $store.group = group;
    },
    goToListing: () => {
      $store.group = null;
    },
    fetchGroups() {
      $store.error = null
      let data = {}

      //Are we fetching for a specific leader?
      if ($store.leader) {
        data.assigned_to = [toString(this.leader.ID)]
      }

      //Fetch the groups
      $.ajax({
        url: `${ wpApiDashboard.site_url }/wp-json/dt-posts/v2/groups`,
        data,
        headers: {
          'X-WP-Nonce': wpApiDashboard.nonce //Grab the nonce out of the global object provided by the dashboard plugin
        }
      }).then((response) => {
        if (response?.data?.status) {
          //Looks like we got an d
          $store.error = response?.data.message ?? 'An error occurred'
          return
        }

        //We only want to display 6 groups
        response.posts = response.posts.slice(0,6)

        $store.groups = response
      })
    }
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
      store: $store,
      init() {
        //When the leader updates, fetch new groups
        this.$watch('store.leader', () => $store.fetchGroups())
      },
    }
  })

  Alpine.data('groups_card_listing', () => {
    return {
      store: $store
    }
  })

  Alpine.data('groups_card_group', () => {
    return {
      store: $store
    }
  })

  /**
   * The group leader filter typeahead component
   */
  Alpine.data('groups_card_leader_filter', () => {
    return {
      store: $store,
      init() {

        //Use JQUERY typeahead to autocomplete the leader filter
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
            onSearch: function (node, search) {
                if (!search) {
                  $store.leader = null
                }
            },
            onClick: function (node, a, item) {
              $store.leader = item
            }
          },
        });
      }
    }
  })
})
