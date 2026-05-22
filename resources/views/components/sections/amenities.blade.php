<section id="amenities" class="py-32 bg-white">

  <div class="max-w-7xl mx-auto px-6">

      <div class="grid lg:grid-cols-2 gap-20 items-center">

          {{-- LEFT --}}
          <div>

              <p class="uppercase tracking-[0.3em] text-sm text-text-secondary mb-4">
                  Amenities
              </p>

              <h2 class="font-serif text-5xl lg:text-6xl text-primary leading-tight mb-8">
                  Designed For Modern Urban Living
              </h2>

              <p class="text-lg leading-relaxed text-text-secondary">
                  Every corner of Arcadia is thoughtfully designed to create
                  a calm, elegant, and comfortable environment.
              </p>

          </div>

          {{-- RIGHT --}}
          <div class="grid grid-cols-2 gap-6">

              @foreach ([
                  'High-Speed WiFi',
                  'Laundry Service',
                  'Shared Kitchen',
                  '24-Hour Security'
              ] as $item)

                  <div class="border border-border rounded-[28px] p-8 bg-background">

                      <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-6">

                          <span class="material-symbols-outlined text-primary">
                              apartment
                          </span>

                      </div>

                      <h3 class="font-serif text-2xl text-primary mb-3">
                          {{ $item }}
                      </h3>

                      <p class="text-text-secondary">
                          Premium quality facilities for daily comfort.
                      </p>

                  </div>

              @endforeach

          </div>

      </div>

  </div>

</section>