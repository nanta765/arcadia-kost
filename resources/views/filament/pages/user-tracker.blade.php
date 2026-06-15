<x-filament-panels::page>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div x-data="userTracker()" class="tracker-root">

        {{-- Spinner / initial load --}}
        <div x-show="loadingList" class="spinner-center">
            <x-filament::loading-indicator class="w-8 h-8" />
            <span class="text-sm text-gray-400 mt-3">Loading customers...</span>
        </div>

        {{-- Error banner --}}
        <div x-show="error" x-transition class="error-banner">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            <span x-text="error"></span>
        </div>

        {{-- ======== CUSTOMER CARD GRID ======== --}}
        <div x-show="!loadingList && !selectedUserDetail">
            <div class="grid-header">
                <h2>All Customers</h2>
                <span class="grid-count" x-text="customers.length + ' customers'"></span>
            </div>

            <div x-show="customers.length === 0" class="empty-state">
                <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                <p class="empty-title">No customers yet</p>
            </div>

            <div class="customer-grid">
                <template x-for="c in customers" :key="c.id">
                    <div class="customer-card"
                        @click="selectCustomer(c.id)"
                        :class="{ 'card-selected': selectedId === c.id }">
                        <div class="card-avatar">
                            <img
                                :src="profilePhotoUrl(c.profile_photo, c.name)"
                                :alt="c.name"
                                class="card-photo"
                            >
                        </div>
                        <div class="card-body">
                            <h3 class="card-name" x-text="c.name"></h3>
                            <p class="card-email" x-text="c.email"></p>
                            <p class="card-profession" x-text="c.profession || '—'"></p>
                        </div>
                        <div class="card-footer">
                            <div x-show="c.last_booking" class="card-booking-info">
                                <span class="booking-status-dot" :class="'dot-' + (c.last_booking?.status || '')"></span>
                                <span class="text-xs" x-text="(c.last_booking?.room_type || '') + ' · ' + (c.last_booking?.room_number || '')"></span>
                            </div>
                            <span class="card-total-badge" x-text="c.total_bookings + ' booking' + (c.total_bookings !== 1 ? 's' : '')"></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ======== USER DETAIL SECTION ======== --}}
        <div x-show="selectedUserDetail" x-transition class="detail-section">

            {{-- Back button --}}
            <button @click="closeDetail()" class="back-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
                Back to all customers
            </button>

            {{-- Detail spinner --}}
            <div x-show="loadingDetail" class="spinner-center" style="padding: 40px 0;">
                <x-filament::loading-indicator class="w-6 h-6" />
            </div>

            <div x-show="!loadingDetail" class="results-grid">

                {{-- User Profile Card --}}
                <div class="profile-card">
                    <div class="profile-top">
                        <div class="profile-photo-wrapper">
                            <img
                                :src="profilePhotoUrl(selectedUserDetail.user.profile_photo, selectedUserDetail.user.name)"
                                :alt="selectedUserDetail.user.name"
                                class="profile-photo"
                            >
                        </div>
                        <div class="profile-names">
                            <h2 class="profile-name" x-text="selectedUserDetail.user.name"></h2>
                            <p class="profile-email" x-text="selectedUserDetail.user.email"></p>
                            <span class="role-badge" :class="{
                                'role-owner': selectedUserDetail.user.role === 'owner',
                                'role-staff': selectedUserDetail.user.role === 'staff',
                                'role-customer': selectedUserDetail.user.role === 'customer',
                            }" x-text="selectedUserDetail.user.role"></span>
                        </div>
                    </div>
                    <div class="profile-details">
                        <div class="detail-item">
                            <span class="detail-label">Phone</span>
                            <span class="detail-value" x-text="selectedUserDetail.user.phone_number || '—'"></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Profession</span>
                            <span class="detail-value" x-text="selectedUserDetail.user.profession || '—'"></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Address</span>
                            <span class="detail-value" x-text="selectedUserDetail.user.address || '—'"></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Joined</span>
                            <span class="detail-value" x-text="formatDate(selectedUserDetail.user.created_at)"></span>
                        </div>
                    </div>
                </div>

                {{-- Booking History --}}
                <div class="section-card">
                    <div class="section-header">
                        <h3>Booking History</h3>
                        <span class="section-count" x-text="'(' + selectedUserDetail.bookings.length + ')'"></span>
                    </div>
                    <div x-show="selectedUserDetail.bookings.length === 0" class="section-empty">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819"/>
                        </svg>
                        <p>No bookings found for this user.</p>
                    </div>
                    <div x-show="selectedUserDetail.bookings.length > 0" class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Room</th>
                                    <th>Type</th>
                                    <th>Period</th>
                                    <th>Duration</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="b in selectedUserDetail.bookings" :key="b.id">
                                    <tr>
                                        <td class="font-medium" x-text="b.room_number || '—'"></td>
                                        <td x-text="b.room_type || '—'"></td>
                                        <td class="text-sm">
                                            <span x-text="formatDate(b.start_date)"></span>
                                            <span class="text-gray-400 mx-1">→</span>
                                            <span x-text="formatDate(b.end_date)"></span>
                                        </td>
                                        <td x-text="b.duration_months + ' mo'"></td>
                                        <td class="font-medium" x-text="formatRupiah(b.total_price)"></td>
                                        <td>
                                            <span class="status-badge" :class="'status-' + b.status_color" x-text="b.status"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Payment History --}}
                <div class="section-card">
                    <div class="section-header">
                        <h3>Payment History</h3>
                        <span class="section-count" x-text="'(' + selectedUserDetail.payments.length + ')'"></span>
                    </div>
                    <div x-show="selectedUserDetail.payments.length === 0" class="section-empty">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/>
                        </svg>
                        <p>No payment records found.</p>
                    </div>
                    <div x-show="selectedUserDetail.payments.length > 0" class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="p in selectedUserDetail.payments" :key="p.id">
                                    <tr>
                                        <td class="font-medium" x-text="'#' + p.booking_id"></td>
                                        <td class="font-medium" x-text="formatRupiah(p.amount)"></td>
                                        <td x-text="(p.payment_method || 'bank_transfer').replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())"></td>
                                        <td>
                                            <span class="status-badge" :class="'status-' + p.status_color" x-text="p.status"></span>
                                        </td>
                                        <td class="text-sm" x-text="formatDate(p.date)"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Profit Section --}}
                <div class="section-card profit-section">
                    <div class="section-header">
                        <h3>Profit Overview</h3>
                        <span class="text-xs text-gray-400" x-text="profitData ? 'Gross / Net' : 'Loading...'"></span>
                    </div>
                    <div class="profit-cards">
                        <div class="profit-card">
                            <div class="profit-card-icon profit-icon-gross">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="profit-card-label">Gross Profit</p>
                                <p class="profit-card-value" x-text="profitData ? formatRupiah(profitData.total_gross) : '—'"></p>
                            </div>
                        </div>
                        <div class="profit-card">
                            <div class="profit-card-icon profit-icon-net">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="profit-card-label">Net Profit</p>
                                <p class="profit-card-value" x-text="profitData ? formatRupiah(profitData.total_net) : '—'"></p>
                                <p class="profit-card-sub">After cost per booking (Rp 1,4M)</p>
                            </div>
                        </div>
                        <div class="profit-card">
                            <div class="profit-card-icon profit-icon-deduction">
                                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="profit-card-label">Deduction</p>
                                <p class="profit-card-value" x-text="profitData ? formatRupiah(profitData.total_gross - profitData.total_net) : '—'"></p>
                                <p class="profit-card-sub">Total operational cost</p>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="profitChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tracker-root { display: flex; flex-direction: column; gap: 20px; }

        /* Spinner */
        .spinner-center { display: flex; flex-direction: column; align-items: center; padding: 64px 0; color: #9ca3af; }

        /* Error */
        .error-banner { display: flex; align-items: center; gap: 10px; padding: 14px 18px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; color: #991b1b; font-size: 14px; }
        .dark .error-banner { background: #451a1a; border-color: #7f1d1d; color: #fca5a5; }

        /* Empty */
        .empty-state { display: flex; flex-direction: column; align-items: center; padding: 64px 24px; color: #9ca3af; text-align: center; }
        .empty-state svg { opacity: 0.3; margin-bottom: 16px; }
        .empty-title { font-size: 18px; font-weight: 700; color: #6b7280; margin: 0; }
        .dark .empty-title { color: #9ca3af; }

        /* Grid header */
        .grid-header { display: flex; align-items: baseline; gap: 10px; margin-bottom: 16px; }
        .grid-header h2 { font-size: 18px; font-weight: 700; color: #111827; margin: 0; }
        .dark .grid-header h2 { color: #f9fafb; }
        .grid-count { font-size: 13px; color: #9ca3af; }

        /* Customer Cards Grid */
        .customer-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }
        .customer-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; cursor: pointer; transition: all 0.2s; }
        .dark .customer-card { background: #111827; border-color: #1f2937; }
        .customer-card:hover { border-color: #d97706; box-shadow: 0 4px 12px rgba(217,119,6,0.1); transform: translateY(-2px); }
        .card-selected { border-color: #d97706 !important; box-shadow: 0 0 0 2px rgba(217,119,6,0.2); }
        .card-avatar { width: 48px; height: 48px; border-radius: 50%; overflow: hidden; flex-shrink: 0; background: #fef3c7; margin-bottom: 12px; }
        .card-photo { width: 100%; height: 100%; object-fit: cover; }
        .card-body { margin-bottom: 14px; }
        .card-name { font-size: 16px; font-weight: 700; color: #111827; margin: 0 0 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dark .card-name { color: #f9fafb; }
        .card-email { font-size: 13px; color: #6b7280; margin: 0 0 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dark .card-email { color: #9ca3af; }
        .card-profession { font-size: 12px; color: #9ca3af; margin: 0; }
        .card-footer { display: flex; align-items: center; justify-content: space-between; border-top: 1px solid #f3f4f6; padding-top: 12px; }
        .dark .card-footer { border-color: #1f2937; }
        .card-booking-info { display: flex; align-items: center; gap: 6px; color: #6b7280; }
        .booking-status-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .dot-active, .dot-completed { background: #10b981; }
        .dot-pending { background: #f59e0b; }
        .dot-review { background: #3b82f6; }
        .dot-cancelled { background: #ef4444; }
        .card-total-badge { font-size: 11px; font-weight: 600; color: #6b7280; background: #f3f4f6; padding: 2px 8px; border-radius: 10px; }
        .dark .card-total-badge { background: #374151; color: #d1d5db; }

        /* Back button */
        .back-btn { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; font-weight: 600; color: #d97706; background: none; border: none; cursor: pointer; padding: 0; width: fit-content; }
        .back-btn:hover { color: #b45309; }

        /* Detail */
        .detail-section { display: flex; flex-direction: column; gap: 16px; }
        .results-grid { display: flex; flex-direction: column; gap: 20px; }

        /* Profile Card */
        .profile-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; }
        .dark .profile-card { background: #111827; border-color: #1f2937; }
        .profile-top { display: flex; align-items: center; gap: 20px; margin-bottom: 24px; }
        .profile-photo-wrapper { width: 72px; height: 72px; border-radius: 50%; overflow: hidden; flex-shrink: 0; background: #fef3c7; border: 3px solid #fde68a; }
        .profile-photo { width: 100%; height: 100%; object-fit: cover; }
        .profile-names { min-width: 0; }
        .profile-name { font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 4px; }
        .dark .profile-name { color: #f9fafb; }
        .profile-email { font-size: 14px; color: #6b7280; margin: 0 0 8px; }
        .dark .profile-email { color: #9ca3af; }
        .role-badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .role-owner { background: #fef3c7; color: #92400e; }
        .role-staff { background: #dbeafe; color: #1e40af; }
        .role-customer { background: #f3f4f6; color: #374151; }
        .dark .role-customer { background: #374151; color: #d1d5db; }
        .profile-details { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
        .detail-item { display: flex; flex-direction: column; gap: 4px; }
        .detail-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; font-weight: 600; }
        .detail-value { font-size: 14px; color: #111827; font-weight: 500; }
        .dark .detail-value { color: #f9fafb; }

        /* Section Card */
        .section-card { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
        .dark .section-card { background: #111827; border-color: #1f2937; }
        .section-header { display: flex; align-items: center; gap: 8px; padding: 18px 24px; border-bottom: 1px solid #f3f4f6; }
        .dark .section-header { border-color: #1f2937; }
        .section-header h3 { font-size: 16px; font-weight: 700; color: #111827; margin: 0; }
        .dark .section-header h3 { color: #f9fafb; }
        .section-count { font-size: 13px; color: #9ca3af; }
        .section-empty { display: flex; flex-direction: column; align-items: center; padding: 48px 24px; color: #9ca3af; gap: 12px; font-size: 14px; }
        .section-empty svg { opacity: 0.35; }

        /* Tables */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f9fafb; }
        .dark thead { background: #1f2937; }
        th { padding: 12px 20px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280; font-weight: 600; white-space: nowrap; }
        .dark th { color: #9ca3af; }
        td { padding: 14px 20px; font-size: 14px; color: #374151; border-top: 1px solid #f3f4f6; white-space: nowrap; }
        .dark td { color: #d1d5db; border-top-color: #1f2937; }
        tbody tr:hover { background: #f9fafb; }
        .dark tbody tr:hover { background: #1a2332; }

        /* Status Badges */
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: capitalize; }
        .status-success { background: #ecfdf5; color: #065f46; }
        .status-warning { background: #fffbeb; color: #92400e; }
        .status-info { background: #eff6ff; color: #1e40af; }
        .status-danger { background: #fef2f2; color: #991b1b; }
        .status-gray { background: #f3f4f6; color: #374151; }
        .dark .status-success { background: #064e3b; color: #6ee7b7; }
        .dark .status-warning { background: #78350f; color: #fde68a; }
        .dark .status-info { background: #1e3a5f; color: #93c5fd; }
        .dark .status-danger { background: #7f1d1d; color: #fca5a5; }
        .dark .status-gray { background: #374151; color: #d1d5db; }

        /* Profit */
        .profit-section { padding: 0; }
        .profit-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; padding: 24px; }
        .profit-card { display: flex; align-items: flex-start; gap: 14px; padding: 18px; border: 1px solid #f3f4f6; border-radius: 12px; background: #fafafa; }
        .dark .profit-card { background: #1a2332; border-color: #1f2937; }
        .profit-card-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .profit-icon-gross { background: #fef3c7; color: #b45309; }
        .profit-icon-net { background: #ecfdf5; color: #047857; }
        .profit-icon-deduction { background: #fef2f2; color: #b91c1c; }
        .profit-card-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; font-weight: 600; margin: 0 0 6px; }
        .profit-card-value { font-size: 20px; font-weight: 700; color: #111827; margin: 0; }
        .dark .profit-card-value { color: #f9fafb; }
        .profit-card-sub { font-size: 12px; color: #6b7280; margin: 4px 0 0; }
        .dark .profit-card-sub { color: #9ca3af; }
        .chart-container { padding: 0 24px 24px; height: 320px; position: relative; }
    </style>

    <script>
        function userTracker() {
            return {
                customers: [],
                loadingList: true,
                error: null,

                selectedId: null,
                selectedUserDetail: null,
                loadingDetail: false,
                chartInstance: null,
                profitData: null,

                getCSRF() {
                    return document.querySelector('meta[name="csrf-token"]')?.content || '';
                },

                init() {
                    this.fetchCustomers();
                },

                async fetchCustomers() {
                    this.loadingList = true;
                    this.error = null;
                    try {
                        const res = await fetch('/admin/tracker/customers', {
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCSRF() },
                        });
                        if (!res.ok) throw new Error('Failed to load');
                        const data = await res.json();
                        this.customers = data.users || [];
                    } catch (e) {
                        this.error = 'Failed to load customers. Please refresh.';
                    } finally {
                        this.loadingList = false;
                    }
                },

                async selectCustomer(id) {
                    this.selectedId = id;
                    this.selectedUserDetail = null;
                    this.loadingDetail = true;
                    this.error = null;
                    this.destroyChart();

                    try {
                        const res = await fetch('/admin/tracker/customers/search?id=' + encodeURIComponent(id), {
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCSRF() },
                        });
                        if (!res.ok) {
                            const err = await res.json().catch(() => ({}));
                            this.error = err.error || 'Failed to load user detail.';
                            return;
                        }
                        const data = await res.json();
                        if (!data.found) {
                            this.error = 'User not found.';
                            return;
                        }
                        this.selectedUserDetail = data;
                        await this.fetchProfit(id);
                        this.$nextTick(() => this.renderChart());
                    } catch (e) {
                        this.error = 'Network error. Please try again.';
                    } finally {
                        this.loadingDetail = false;
                    }
                },

                async fetchProfit(userId) {
                    try {
                        const url = userId
                            ? '/admin/tracker/profit?user_id=' + encodeURIComponent(userId)
                            : '/admin/tracker/profit';
                        const res = await fetch(url, {
                            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.getCSRF() },
                        });
                        if (res.ok) {
                            this.profitData = await res.json();
                        }
                    } catch (e) {
                        // profit fetch is non-blocking
                    }
                },

                closeDetail() {
                    this.selectedId = null;
                    this.selectedUserDetail = null;
                    this.profitData = null;
                    this.destroyChart();
                },

                formatRupiah(value) {
                    return 'Rp ' + Number(value).toLocaleString('id-ID');
                },
                formatDate(dateStr) {
                    if (!dateStr) return '-';
                    const d = new Date(dateStr);
                    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                },
                profilePhotoUrl(photo, name) {
                    if (!photo) return 'https://ui-avatars.com/api/?name=' + encodeURIComponent(name || 'User') + '&background=fef3c7&color=92400e&size=80';
                    return '/' + photo.replace(/^\/+/, '');
                },

                renderChart() {
                    const canvas = document.getElementById('profitChart');
                    if (!canvas || this.chartInstance || !this.profitData) return;
                    const ctx = canvas.getContext('2d');

                    const grossInM = this.profitData.gross.map(v => Math.round(v / 1000000));
                    const netInM = this.profitData.net.map(v => Math.round(v / 1000000));

                    this.chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: this.profitData.labels,
                            datasets: [
                                {
                                    label: 'Gross Profit',
                                    data: grossInM,
                                    borderColor: '#f59e0b',
                                    backgroundColor: 'rgba(245,158,11,0.12)',
                                    borderWidth: 2.5,
                                    tension: 0.4,
                                    fill: true,
                                    pointRadius: 5,
                                    pointBackgroundColor: '#f59e0b',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 8,
                                },
                                {
                                    label: 'Net Profit',
                                    data: netInM,
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16,185,129,0.08)',
                                    borderWidth: 2.5,
                                    borderDash: [6, 3],
                                    tension: 0.4,
                                    fill: true,
                                    pointRadius: 5,
                                    pointBackgroundColor: '#10b981',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointHoverRadius: 8,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 24,
                                        color: '#6b7280',
                                        font: { size: 12 },
                                    },
                                },
                                tooltip: {
                                    padding: 14,
                                    backgroundColor: 'rgba(17,24,39,0.92)',
                                    titleColor: '#f9fafb',
                                    bodyColor: '#d1d5db',
                                    borderColor: 'rgba(245,158,11,0.3)',
                                    borderWidth: 1,
                                    cornerRadius: 10,
                                    displayColors: true,
                                    titleFont: { weight: '600', size: 13 },
                                    bodyFont: { size: 13 },
                                    callbacks: {
                                        title: function(items) { return items[0].label; },
                                        label: function(context) {
                                            const idx = context.dataIndex;
                                            const key = context.datasetIndex === 0 ? 'gross' : 'net';
                                            const raw = this.profitData?.[key]?.[idx] ?? 0;
                                            return (context.datasetIndex === 0 ? 'Gross: ' : 'Net: ') + 'Rp ' + new Intl.NumberFormat('id-ID').format(raw);
                                        }.bind(this),
                                    },
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    ticks: {
                                        padding: 10,
                                        color: '#9ca3af',
                                        font: { size: 11 },
                                        callback: function(value) { return 'Rp ' + value + 'M'; },
                                    },
                                    grid: { drawBorder: false, color: 'rgba(0,0,0,0.05)', lineWidth: 1 },
                                    border: { display: false },
                                },
                                x: {
                                    ticks: { color: '#9ca3af', font: { size: 11 }, padding: 8 },
                                    grid: { display: false },
                                    border: { display: false },
                                },
                            },
                        },
                    });
                },

                destroyChart() {
                    if (this.chartInstance) { this.chartInstance.destroy(); this.chartInstance = null; }
                },
            };
        }
    </script>
</x-filament-panels::page>
