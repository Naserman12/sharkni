   @livewireScripts
        <script>
           window.addEventListener('languageChanged', () =>{
                    window.location.reload();
            });
  function filterComponent() {
    return {
      isOpen: false,

      init() {
        const savedState = localStorage.getItem('filtersOpen');
        this.isOpen = savedState === 'true';
      },

      toggle() {
        this.isOpen = !this.isOpen;
        localStorage.setItem('filtersOpen', this.isOpen);
      }
    }
  }


        </script>
    </body>
</html>
