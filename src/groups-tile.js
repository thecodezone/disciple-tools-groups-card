let $store = null;
let $initalUser = null;

document.addEventListener('alpine:init', () => {
  /**
   * Create a data store to share data between components.
   */
  $store = null
  Alpine.store('groupsTile', {
    groups: [],
    offset: 0,
    perPage: 6,
    total: 0,
    text: '',
    group: null,
    tile: null,
    user: null,
    error: null,
    numResults: null,
    get page() {
      return Math.floor(this.offset / this.perPage) + 1
    },
    get pages() {
      return Math.ceil(this.groups.total / this.perPage)
    },
    get hasSearched() {
      return this.numResults !== null
    },
    get hasResults() {
      return this.numResults > 0
    },
    setGroup(group) {
      $store.group = group;
    },
    next() {
      if ($store.offset + $store.perPage < $store.groups.total) {
        $store.offset += $store.perPage;
        this.fetchGroups()
      }
    },
    prev() {
      if ($store.offset > 0) {
        $store.offset -= $store.perPage;
        this.fetchGroups()
      }
    },
    setPage(page) {
      $store.offset = (page - 1) * $store.perPage;
      this.fetchGroups()
    },
    goToListing: () => {
      $store.group = null;
    },
    reset: () => {
      $store.group = null
      $store.offset = 0
      $store.total = 0
    },
    async fetchGroups() {
      $store.error = null
      $store.numResults = null
      let data = {}

      //Are we searching?
      if ($store.text) {
        data.text = $store.text
      }

      //Handle paging
      if ($store.offset) {
        data.offset = $store.offset
      }

      //Are we fetching for a specific leader?
      if ($store.user) {
        data.assigned_to = [$store.user.ID]
      }

      //Fetch the groups
      $.ajax({
        url: `${wpApiDashboard.site_url}/wp-json/dt-posts/v2/groups`,
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
        response.posts = response.posts.slice(0, $store.perPage)

        $store.groups = response
        $store.numResults = response.total
      }).fail(() => {
        $store.error = 'An error occurred'
        return Promise.reject()
      })

      return Promise.resolve()
    }
  })
  $store = Alpine.store('groupsTile');

  /**
   * The groups tile component
   */
  Alpine.data('groups_tile', ({groups, tile, user}) => {

    //Hydrate the store on init
    $store.groups = groups
    $store.tile = tile
    $store.user = user
    $initalUser = user

    return {
      store: $store,
      init() {
        //When the leader updates, fetch new groups
        this.$watch('store.user', () => $store.fetchGroups())
      },
    }
  })

  /**
   * The groups tile listing view
   */
  Alpine.data('groups_tile_listing', () => {
    return {
      store: $store
    }
  })

  /**
   * The groups tile group view
   */
  Alpine.data('groups_tile_group', () => {
    return {
      perPage: 6,
      offset: 0,
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
      },
      /**
       * Getter for the combined group roster (coaches, leaders and members)
       * @returns {T[]|*[]}
       */
      get rosterPaginated() {
        return this.roster.slice(this.offset, this.offset + this.perPage)
      },
      /**
       * Getter for the number of pages in the paginated roster
       * @returns {number}
       */
      get pages() {
        return Math.ceil(this.roster.length / this.perPage)
      },
      /**
       * Getter for the current page in the paginated roster
       * @returns {number}
       */
      get page() {
        return Math.floor(this.offset / this.perPage) + 1
      },
      /**
       * Set the page number in the paginated roster
       * @param page
       */
      setPage(page) {
        this.offset = (page - 1) * this.perPage;
      },
      /**
       * Go back a page
       */
      prev() {
        if (this.offset > 0) {
          this.offset -= this.perPage;
        }
      },
      /**
       * Go forward a page
       */
      next() {
        if (this.offset + this.perPage < this.roster.length) {
          this.offset += this.perPage;
        }
      },
      /**
       * Fires when the dom is ready
       */
      init() {
        initChurchHealthCircle(this.store.group)
      },
    }
  })

  /**
   *  The groups tile search component
   */
  Alpine.data('groups_tile_search', () => {
    return {
      store: $store,
      search() {
        $store.reset()
        $store.fetchGroups($store.text)
      }
    }
  })

  /**
   * The group leader filter typeahead component
   */
  Alpine.data('groups_tile_leader_filter', () => {
    return {
      store: $store,
      init() {

        //Use JQUERY typeahead to autocomplete the user filter
        $.typeahead({
          input: this.$refs.filter_field,
          minLength: 0,
          accent: true,
          searchOnFocus: true,
          source: TYPEAHEADS.typeaheadUserSource(),
          templateValue: "{{name}}",
          template: function (query, item) {
            return `<span class="row">
          <span>${window.lodash.escape(item.name)}</span>
        </span>`
          },
          dynamic: true,
          hint: true,
          emptyTemplate: window.lodash.escape(window.wpApiShare.translations.no_records_found),
          callback: {
            onSearch: function (node, search) {
              if (!search) {
                $store.user = $initalUser
              }
            },
            onClick: function (node, a, item) {
              $store.reset()
              $store.user = item ? item : $initalUser
            }
          },
        });
      }
    }
  })
})
