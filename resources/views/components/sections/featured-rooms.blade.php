<section id="rooms" class="py-32">

  <div class="max-w-7xl mx-auto px-6">

      {{-- TITLE --}}
      <div class="text-center mb-20">

          <p class="uppercase tracking-[0.3em] text-sm text-text-secondary mb-4">
              Premium Spaces
          </p>

          <h2 class="font-serif text-5xl lg:text-6xl text-primary">
              Curated Spaces
          </h2>

      </div>

      {{-- GRID --}}
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

          <x-cards.room-card
              title="Standard Suite"
              price="Rp2.5jt"
              image="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1200"
          />

          <x-cards.room-card
              title="Deluxe Studio"
              price="Rp3.5jt"
              image="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=1200"
          />

          <x-cards.room-card
              title="Premium Loft"
              price="Rp4.5jt"
              image="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1200"
          />

      </div>

  </div>

</section>