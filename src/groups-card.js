document.addEventListener('alpine:init', () => {
  Alpine.data('groups_card', () => ({
    init() {
        console.log("here")
    }
  }))
})
