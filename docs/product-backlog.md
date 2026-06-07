# Arcadia Kost — Product Backlog

**Last updated:** 2026-06-05
**Sprint cadence:** 2 weeks (suggested)

---

## Epic 1: Payment & Billing

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-001 | **As a** customer, **I want to** pay via Midtrans gateway (bank transfer, e-wallet, QRIS), **so that** I don't have to manually upload a receipt. | P0 — High | 8 | Ready |
| PB-002 | **As a** customer, **I want to** receive an automated invoice/receipt after each payment, **so that** I have proof of transaction without waiting for admin. | P1 — Medium | 3 | Ready |
| PB-003 | **As a** customer, **I want to** see my payment history and outstanding balances, **so that** I can track what I owe. | P1 — Medium | 5 | Ready |
| PB-004 | **As an** owner, **I want to** export payment reports as PDF/Excel filtered by date range, **so that** I can do monthly bookkeeping. | P2 — Low | 5 | Backlog |
| PB-005 | **As a** customer, **I want to** set up auto-debit reminders before my booking period ends, **so that** I never miss a payment deadline. | P3 — Nice-to-have | 8 | Backlog |

---

## Epic 2: Notification & Communication

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-006 | **As a** customer, **I want to** receive email notifications when my booking status changes (confirmed, cancelled, payment received), **so that** I don't need to keep checking the app. | P0 — High | 5 | Ready |
| PB-007 | **As an** owner/staff, **I want to** be notified when a new booking, payment proof, or service request arrives, **so that** I can respond quickly. | P0 — High | 5 | Ready |
| PB-008 | **As a** customer, **I want to** receive WhatsApp notifications for booking/payment updates, **so that** I get instant alerts on my phone. | P2 — Low | 8 | Backlog |
| PB-009 | **As a** customer, **I want to** receive a reminder 3 days before my booking ends, **so that** I can extend before the room is released. | P1 — Medium | 3 | Ready |
| PB-010 | **As a** staff, **I want to** bulk-send announcements to all active residents (e.g., maintenance notice, holiday), **so that** I don't need to message everyone individually. | P3 — Nice-to-have | 5 | Backlog |

---

## Epic 3: Chat System

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-011 | **As a** customer, **I want to** receive chat messages in real-time without waiting for polling, **so that** conversations feel instant. | P1 — Medium | 8 | Ready |
| PB-012 | **As a** customer, **I want to** attach images to chat messages (e.g., photo of room issue), **so that** I can show problems clearly. | P2 — Low | 5 | Backlog |
| PB-013 | **As a** staff, **I want to** see unread message counts and who is online, **so that** I can prioritize which customers to respond to. | P2 — Low | 5 | Backlog |
| PB-014 | **As a** customer, **I want to** receive an email when staff replies while I'm offline, **so that** I don't miss responses. | P3 — Nice-to-have | 3 | Backlog |

---

## Epic 4: Booking & Room Management

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-015 | **As a** customer, **I want to** select a specific room (not just a room type), **so that** I can pick the exact unit I prefer. | P1 — Medium | 5 | Ready |
| PB-016 | **As a** customer, **I want to** choose a custom booking duration (not fixed 1 month), **so that** I can book for the period I actually need. | P1 — Medium | 5 | Ready |
| PB-017 | **As an** owner, **I want to** see a calendar view of all room occupancy, **so that** I can easily spot availability gaps. | P1 — Medium | 8 | Ready |
| PB-018 | **As an** owner, **I want to** schedule room maintenance with a date range, **so that** rooms under repair are automatically blocked from booking. | P2 — Low | 5 | Backlog |
| PB-019 | **As a** customer, **I want to** cancel my booking before check-in and get a refund per policy, **so that** I'm not locked in if plans change. | P2 — Low | 5 | Backlog |
| PB-020 | **As a** customer, **I want to** check room availability in real-time from the landing page, **so that** I can see what's available before registering. | P2 — Low | 3 | Backlog |
| PB-021 | **As an** owner, **I want to** configure peak-season pricing (date-range price overrides), **so that** I can adjust rates during holidays. | P3 — Nice-to-have | 8 | Backlog |

---

## Epic 5: Reviews & Reputation

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-022 | **As an** owner, **I want to** reply to public reviews, **so that** I can address feedback and show responsiveness. | P2 — Low | 3 | Backlog |
| PB-023 | **As a** guest, **I want to** filter reviews by rating and sort by newest/highest, **so that** I can find the most relevant feedback. | P2 — Low | 3 | Backlog |
| PB-024 | **As a** customer, **I want to** upload photos with my review, **so that** I can show the real room condition. | P3 — Nice-to-have | 5 | Backlog |

---

## Epic 6: Admin Dashboard & Reporting

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-025 | **As an** owner, **I want to** see occupancy rate, revenue trends, and booking forecasts on the dashboard, **so that** I can make data-driven business decisions. | P1 — Medium | 8 | Ready |
| PB-026 | **As an** owner, **I want to** export financial reports (income statement, occupancy report) as PDF, **so that** I can share with accountants or investors. | P2 — Low | 8 | Backlog |
| PB-027 | **As an** owner, **I want to** auto-schedule the monthly revenue calculation via cron, **so that** I don't need to manually run the artisan command. | P1 — Medium | 2 | Ready |
| PB-028 | **As an** owner, **I want to** see customer retention metrics (how many extend, how many churn), **so that** I can improve satisfaction. | P3 — Nice-to-have | 5 | Backlog |

---

## Epic 7: Customer Experience

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-029 | **As a** guest, **I want to** see an interactive virtual room tour gallery instead of static cards, **so that** I get a realistic feel of the rooms before booking. | P2 — Low | 5 | Backlog |
| PB-030 | **As a** guest, **I want to** use a room comparison tool, **so that** I can compare features and pricing side by side. | P3 — Nice-to-have | 5 | Backlog |
| PB-031 | **As a** customer, **I want to** fill in a move-in checklist / condition report, **so that** both parties agree on the room's initial state. | P3 — Nice-to-have | 8 | Backlog |
| PB-032 | **As a** customer, **I want to** view and download my booking/rental history, **so that** I have records for tax or employment purposes. | P3 — Nice-to-have | 3 | Backlog |

---

## Epic 8: Platform & Technical Debt

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-033 | **As a** developer, **I want to** add automated tests (feature + unit) covering the critical booking/payment flows, **so that** we can deploy with confidence. | P0 — High | 8 | Ready |
| PB-034 | **As a** developer, **I want to** set up CI/CD pipeline (GitHub Actions) for automated testing and deployment, **so that** releases are repeatable and safe. | P1 — Medium | 5 | Ready |
| PB-035 | **As a** developer, **I want to** clean up duplicate migrations and normalize the schema, **so that** fresh installs don't fail and the codebase is consistent. | P1 — Medium | 3 | Ready |
| PB-036 | **As a** developer, **I want to** extract an API layer for the customer-facing features, **so that** a future mobile app can reuse business logic. | P2 — Low | 13 | Backlog |
| PB-037 | **As a** developer, **I want to** add structured logging and error tracking (e.g., Sentry), **so that** production issues can be diagnosed quickly. | P2 — Low | 3 | Backlog |
| PB-038 | **As a** developer, **I want to** add rate limiting to the chat API endpoints, **so that** the server isn't overwhelmed by the 3-second polling loop under load. | P1 — Medium | 2 | Ready |
| PB-039 | **As an** owner, **I want to** upload and manage room photos (multiple per room type), **so that** the landing page shows attractive visuals. | P1 — Medium | 5 | Ready |
| PB-040 | **As an** owner, **I want to** configure SEO metadata (title, description, OG tags) from the admin panel, **so that** the landing page ranks on Google. | P2 — Low | 3 | Backlog |

---

## Epic 9: Mobile Readiness

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-041 | **As a** customer, **I want to** use a PWA version of the app that works offline for viewing bookings, **so that** I can check status even with slow internet. | P2 — Low | 8 | Backlog |
| PB-042 | **As a** customer, **I want to** receive push notifications when my booking is confirmed, **so that** I get the update without opening the app. | P2 — Low | 5 | Backlog |

---

## Epic 10: Multi-Tenant / Scaling

| ID | User Story | Priority | Effort | Status |
|---|---|---|---|---|
| PB-043 | **As an** owner, **I want to** manage multiple kost locations/branches from one admin panel, **so that** I can expand without separate installations. | P3 — Nice-to-have | 21 | Backlog |
| PB-044 | **As a** guest, **I want to** search for kost by location on a map, **so that** I can find the nearest available room. | P3 — Nice-to-have | 8 | Backlog |

---

## Sprint Planning Recommendations

### Sprint 1 (Foundation hardening) — Suggested first sprint
- PB-033 Automated tests for critical flows (8)
- PB-035 Clean up duplicate migrations (3)
- PB-038 Rate limiting on chat API (2)
- PB-027 Auto-schedule monthly revenue cron (2)
**Total:** 15 points

### Sprint 2 (Notifications MVP)
- PB-006 Customer email notifications (5)
- PB-007 Admin notification alerts (5)
- PB-009 Booking expiry reminder (3)
- PB-039 Room photo management (5)
**Total:** 18 points

### Sprint 3 (Payment modernization)
- PB-001 Midtrans gateway integration (8)
- PB-002 Automated invoice (3)
- PB-003 Payment history view (5)
**Total:** 16 points

### Sprint 4 (Booking flexibility)
- PB-015 Specific room selection (5)
- PB-016 Custom booking duration (5)
- PB-017 Calendar occupancy view (8)
**Total:** 18 points

### Sprint 5 (Real-time + Reports)
- PB-011 WebSocket chat (8)
- PB-025 Enhanced admin dashboard analytics (8)
**Total:** 16 points

---

## Priority Legend

| Label | Meaning |
|---|---|
| **P0 — High** | Must-have; revenue-impacting, security, or broken functionality |
| **P1 — Medium** | Important but not blocking; significant UX improvement |
| **P2 — Low** | Nice to have; can be deferred multiple sprints |
| **P3 — Nice-to-have** | Future consideration; may never be built |

## Effort Legend (Story Points)

| Points | Meaning |
|---|---|
| 1–2 | Trivial / half-day |
| 3 | Small / 1–2 days |
| 5 | Medium / 3–5 days |
| 8 | Large / full sprint |
| 13 | Epic / multiple sprints |
| 21 | Cross-sprint initiative |
