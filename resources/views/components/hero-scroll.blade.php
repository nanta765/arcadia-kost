<div class="flex flex-col overflow-hidden pb-[500px] pt-[1000px]">
  <!-- Container Scroll Animation -->
  <div 
      x-data="containerScroll()" 
      x-init="init()"
      class="h-[60rem] md:h-[80rem] flex items-center justify-center relative p-2 md:p-20"
      x-ref="containerRef"
  >
      <div class="py-10 md:py-40 w-full relative" style="perspective: 1000px;">
          <!-- Header -->
          <div 
              x-bind:style="`transform: translateY(${translate})`"
              class="max-w-5xl mx-auto text-center"
          >
              {{ $titleComponent }}
          </div>
          
          <!-- Animated Card -->
          <div 
              x-bind:style="`
                  transform: rotateX(${rotate}) scale(${scale});
                  box-shadow: 0 0 #0000004d, 0 9px 20px #0000004a, 0 37px 37px #00000042, 0 84px 50px #00000026, 0 149px 60px #0000000a, 0 233px 65px #00000003;
              `"
              class="max-w-5xl -mt-12 mx-auto h-[30rem] md:h-[40rem] w-full border-4 border-[#6C6C6C] p-2 md:p-6 bg-[#222222] rounded-[30px] shadow-2xl"
          >
              <div class="h-full w-full overflow-hidden rounded-2xl bg-gray-100 dark:bg-zinc-900 md:rounded-2xl md:p-4">
                  {{ $slot }}
              </div>
          </div>
      </div>
  </div>
</div>

<script>
function containerScroll() {
  return {
      containerRef: null,
      scrollYProgress: 0,
      isMobile: false,
      rotate: 20,
      scale: 1.05,
      translate: 0,
      
      init() {
          this.containerRef = this.$refs.containerRef;
          this.checkMobile();
          window.addEventListener('resize', () => this.checkMobile());
          this.scrollListener = () => this.updateScroll();
          window.addEventListener('scroll', this.scrollListener);
      },
      
      checkMobile() {
          this.isMobile = window.innerWidth <= 768;
          this.updateScale();
      },
      
      updateScroll() {
          const rect = this.containerRef.getBoundingClientRect();
          const scrollPercent = Math.max(0, Math.min(1, (window.scrollY - rect.top) / (rect.height)));
          this.scrollYProgress = scrollPercent;
          this.updateAnimations();
      },
      
      updateScale() {
          this.scale = this.isMobile ? 0.9 : 1;
      },
      
      updateAnimations() {
          this.rotate = 20 - (this.scrollYProgress * 20);
          this.scale = this.isMobile 
              ? 0.7 + (this.scrollYProgress * 0.2)
              : 1.05 - (this.scrollYProgress * 0.05);
          this.translate = -100 * this.scrollYProgress;
      }
  }
}
</script>