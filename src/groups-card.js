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
    fetchGroups(text = null) {
      $store.error = null
      let data = {}

      //Are we searching?
      if (text) {
        data.text = text
      }

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

  /**
   * The groups card listing view
   */
  Alpine.data('groups_card_listing', () => {
    return {
      store: $store
    }
  })

  /**
   * The groups card group view
   */
  Alpine.data('groups_card_group', () => {
    return {
      store: $store,
      /**
       * Getter for group coaches
       * @returns {T[]|*[]}
       */
      get coaches() {
        return this.store?.group?.coaches ? this.store.group.coaches.map(member => {
          member.role = 'coach'
          return member
        }) : []
      },
      /**
       * Getter for group leaders
       * @returns {T[]|*[]}
       */
      get leaders() {
        return this.store?.group?.leaders ? this.store.group.leaders.map(member => {
          member.role = 'leader'
          return member
        }) : []
      },
      /**
       * Getter for group members
       * @returns {T[]|*[]}
       */
      get members() {
        return this.store?.group?.members ? this.store.group.members.map(member => {
          member.role = 'member'
          return member
        }) : []
      },
      /**
       * Getter for the combined group roster (coaches, leaders and members)
       * @returns {T[]|*[]}
       */
      get roster() {
        return [
          ...this.coaches,
          ...this.leaders,
          ...this.members
        ].reduce((roster, member) => {
          //Make sure we don't have duplicates in case a coach or leader is also a member
          if (roster.find(m => m.ID === member.ID)) {
            return roster
          }
          return [...roster, member]
        }, [])
      }
    }
  })

  /**
   *  The groups card search component
   */
  Alpine.data('groups_card_search', () => {
    return {
      store: $store,
      text: '',
      search() {
        $store.fetchGroups(this.text)
      }
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
