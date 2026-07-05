---
name: pentathree-sprint-planning
description: Sprint planning guide for the PentaThree SIMHOSUV Laravel project. Use when asked to plan, prioritize, estimate, or sequence Agile sprints for this project based on the current codebase, especially auth, admin CRUD, homestay, souvenir, cart, checkout, payment, invoice, reservation, report, ERD alignment, tests, and project-finish criteria.
---

# PentaThree Sprint Planning

## Purpose

Use this skill to turn the current SIMHOSUV codebase into an Agile sprint roadmap. Plan from what exists in code first, not from the full ideal ERD, then add missing business workflows in small releasable increments.

## Current Baseline

Treat these modules as completed or active:

- Auth: login, register, logout.
- Role access: admin and user.
- Profile management.
- Admin CRUD: homestay, kategori homestay, souvenir.
- Customer catalog: homestay and souvenir listing.
- Cart: keranjang and keranjang_items.
- Dynamic admin dashboard using database counts.
- Pemesanan core: `pemesanans` and `detail_pemesanans`.
- Souvenir checkout: cart converts into pemesanan and detail_pemesanans.
- Customer order history and order detail pages.
- Payment core with payment proof upload and admin verification.
- Homestay booking flow using pemesanans and detail_pemesanans.
- Admin reservation management for homestay bookings.
- Storage link workflow for uploaded profile photos.
- Tests: feature tests for homestay, kategori homestay, souvenir, pemesanan, souvenir checkout, payment, homestay booking, and admin reservation management.
- CI/build: tests, Pint, and Vite build are expected verification gates.

Treat these modules as not complete:

- Public homepage.
- Midtrans production payment activation.
- Invoice generation.
- Reports/statistics.
- Reviews/ulasan.
- Facilities/fasilitas.
- Payment gateway webhook.

## Planning Rules

- Plan from the existing code structure before adding new entities.
- Prefer MVP transaction flow before optional features.
- Finish one user journey end-to-end before starting another.
- Build payment core first with internal status and admin verification before integrating Midtrans.
- Move Midtrans Snap Sandbox after checkout, payment core, invoice, reservation, and reports are stable.
- Treat Midtrans Production mode as real-money scope that needs merchant activation and owner/business legal documents; do not make it part of MVP unless explicitly requested.
- Use the same naming style as the project: Indonesian domain names are acceptable.
- Add tests per sprint for the workflow being delivered.
- Keep each sprint demoable.

## Recommended Data Model Additions

Tables already added:

1. `pemesanans`
2. `detail_pemesanans`

Add remaining tables in this order:

1. `pembayarans`
2. `invoices`
3. `ulasans` only after orders/reservations are complete
4. `fasilitas` and `homestay_fasilitas` only if homestay detail needs facility management

Use one `detail_pemesanans` table for MVP instead of separate souvenir and homestay detail tables:

- `detail_pemesanan_id`
- `pemesanan_id`
- `homestay_id` nullable
- `souvenir_id` nullable
- `nama_item`
- `harga`
- `jumlah`
- `check_in` nullable
- `check_out` nullable
- `jumlah_malam` nullable
- `subtotal`

Use `pemesanans.jenis_pemesanan` to distinguish:

- `souvenir`
- `homestay`

## Sprint Roadmap

### Sprint 0 - Stabilization - Done

Goal: make the existing project clean and trustworthy.

Backlog:

- Fix homestay migration rollback: drop `homestays`, not `homestay`.
- Run Pint and fix formatting.
- Replace dummy admin dashboard numbers with database counts.
- Sync README/status docs with actual implementation.
- Verify `php artisan test` and `npm run build`.

Acceptance:

- Tests pass.
- Build passes.
- Dashboard shows real counts.
- No obvious documentation mismatch for implemented modules.

Done outputs:

- Fixed homestay rollback migration.
- Ran Pint formatting.
- Replaced dummy admin dashboard numbers with database counts.
- Synced README/status docs with implementation.
- Verified Pint, tests, and build.

### Sprint 1 - Pemesanan Core - Done

Goal: create a reusable order backbone for souvenir and homestay.

Backlog:

- Create `pemesanans` migration/model/relation.
- Create `detail_pemesanans` migration/model/relation.
- Add relations from User, Souvenir, Homestay.
- Add status constants or documented status values.
- Add tests for model relations and order creation.

Acceptance:

- A user can have many pemesanans.
- A pemesanan can have many detail_pemesanans.
- Detail can point to souvenir or homestay.
- Order total can be stored consistently.

Done outputs:

- Added `pemesanans` table.
- Added `detail_pemesanans` table.
- Added `Pemesanan` and `DetailPemesanan` models.
- Added relationships from User, Souvenir, and Homestay.
- Added automatic code format `PMS-YYYYMMDD-0001`.
- Added Pemesanan feature tests.

### Sprint 2 - Souvenir Checkout - Done

Goal: finish souvenir purchase from cart to pemesanan.

Backlog:

- Convert cart checkout into pemesanan creation.
- Copy cart items into detail_pemesanans.
- Validate stock before checkout.
- Empty cart after successful checkout.
- Create customer order history page.
- Create customer order detail page.
- Add checkout tests.

Acceptance:

- User can add souvenir to cart.
- User can checkout cart into pemesanan.
- Cart is cleared after checkout.
- User can see order history and detail.
- Stock is not reduced yet unless payment is verified.

Done outputs:

- Added POST checkout from cart.
- Copied cart items into detail_pemesanans.
- Validated stock before checkout.
- Cleared cart after checkout success.
- Added customer order history page.
- Added customer order detail page.
- Added checkout tests.

### Sprint 3 - Payment Core - Done

Goal: create internal payment records and admin verification so souvenir checkout can be completed without external gateway risk.

Backlog:

- Create `pembayarans` migration/model/relation.
- Add relationship: Pemesanan hasOne/hasMany Pembayaran, Pembayaran belongsTo Pemesanan.
- Add "Bayar Sekarang" action from customer order detail.
- Add customer payment page for unpaid pemesanan.
- For MVP, allow customer to choose a manual/simulated method and upload payment proof.
- Store payment method, amount, proof image, payment date, status, and admin note.
- Add admin payment list page.
- Add admin payment detail page.
- Add admin verify payment action.
- Add admin reject payment action.
- On verified souvenir payment: set payment status to `terverifikasi`, set pemesanan status to `diproses`, reduce souvenir stock, and increase `jumlah_terjual`.
- On rejected payment: set payment status to `ditolak`, set pemesanan status back to `menunggu_pembayaran`, and do not change stock.
- Prevent duplicate stock reduction if a payment is verified more than once.
- Add tests for upload, admin access, verification side effects, rejection, and duplicate verification safety.

Acceptance:

- User can create a payment record for an unpaid order.
- Admin can verify or reject payment.
- Verified payment updates pemesanan status.
- Souvenir stock and sold count update exactly once.
- Rejected payment does not reduce stock.
- Customer can see payment status from order detail.
- Admin can monitor payment status.

Done outputs:

- Added `pembayarans` table and `Pembayaran` model.
- Added customer payment proof upload page.
- Added admin payment list and detail pages.
- Added verify and reject payment actions.
- Verified souvenir payment updates payment status, pemesanan status, stock, and sold count.
- Rejected payment returns pemesanan to waiting payment without changing stock.
- Prevented duplicate stock reduction.
- Added payment feature tests.

### Sprint 4 - Invoice - Skipped Temporarily

Goal: generate invoice after valid payment.

Backlog:

- Create `invoices` migration/model/relation.
- Generate invoice number after payment verification.
- Add customer invoice page.
- Add admin invoice view.
- Add browser print button.
- Add tests for invoice generation.

Acceptance:

- Verified payment creates invoice.
- Invoice links to pemesanan.
- User and admin can view invoice.
- Invoice total matches pemesanan total.

Current decision:

- Invoice is delayed so the project can finish homestay reservation flow first.
- Return to invoice after admin reservation management is stable.

### Sprint 5 - Homestay Booking - Done

Goal: create reservation flow using the same pemesanan backbone.

Backlog:

- Add booking form from homestay listing/detail.
- Validate check-in/check-out.
- Calculate nights and subtotal.
- Save `jenis_pemesanan = homestay`.
- Save homestay detail in detail_pemesanans.
- Add customer reservation history.
- Add tests for date validation and booking creation.

Acceptance:

- User can book a homestay for a valid date range.
- Invalid date ranges fail.
- Booking creates pemesanan and detail_pemesanan.
- Status starts as `menunggu_pembayaran`.

Done outputs:

- Added booking form from homestay catalog.
- Added booking routes for create and store.
- Added validation for check-in, check-out, and guest count.
- Calculated total nights and subtotal.
- Saved booking as `jenis_pemesanan = homestay`.
- Saved homestay detail into `detail_pemesanans`.
- Updated order detail page to show nights and stay dates.
- Added homestay booking feature tests.

### Sprint 6 - Admin Reservation Management - Done

Goal: let admin manage homestay reservations.

Backlog:

- Build admin reservation list/detail from pemesanans.
- Add status changes: confirm, cancel, finish.
- Add filters by status/date.
- Prevent deleting homestay if active reservation exists, or handle it safely.
- Add tests for admin authorization and status changes.

Acceptance:

- Admin can view reservation list/detail.
- Admin can update reservation status.
- Customer can see status changes.

Done outputs:

- Added admin reservation list from homestay pemesanans.
- Added admin reservation detail page.
- Added reservation status update action.
- Added status filter on reservation list.
- Protected homestay deletion when active reservations still exist.
- Added admin reservation feature tests.

### Sprint 6.5 - Stabilization and Demo Readiness - Done

Goal: clean up small logic gaps and stale UI text before adding new features.

Backlog:

- Make customer homestay filters run through backend query parameters.
- Redirect legacy customer reservation routes to the active order and booking flows.
- Restrict admin payment detail, verify, and reject actions to souvenir payments only.
- Add missing reservation status filters for admin.
- Tighten admin status validation for homestay and souvenir CRUD.
- Remove stale placeholder copy that says active flows are unavailable.
- Add regression tests for the stabilization fixes.

Acceptance:

- Customer homestay category, status, and guest filters return correct results.
- Legacy reservation pages no longer show unavailable-feature placeholders.
- Admin payment module cannot access homestay payment records by direct URL.
- Admin can filter reservations by payment workflow statuses.
- Invalid status values are rejected by admin CRUD validation.
- Tests and build pass.

Done outputs:

- Added backend filtering to customer homestay catalog.
- Redirected legacy reservation routes to order history and booking flow.
- Scoped admin payment show, verify, and reject actions to souvenir payments.
- Added `menunggu_verifikasi` and `diproses` to admin reservation filters.
- Replaced loose status string validation with allowed status values.
- Removed stale sprint/placeholder wording from checkout, reservation, and report pages.
- Added feature test coverage for the stabilization fixes.

### Sprint 7 - Reports - Done

Goal: create useful owner/admin reports.

Backlog:

- Add revenue summary.
- Add souvenir sales report.
- Add homestay reservation report.
- Add date range filters.
- Update admin dashboard with real totals.
- Add tests for report queries where practical.

Acceptance:

- Admin can filter reports by date.
- Report totals match verified payments/invoices.
- Dashboard no longer uses dummy business numbers.

Done outputs:

- Added admin report queries for verified revenue.
- Added souvenir sales report from verified souvenir payments.
- Added homestay reservation status report.
- Added date range filters.
- Added latest verified payment table.
- Updated admin dashboard with monthly verified revenue, pending payment count, and active reservation count.
- Added report feature tests.

### Sprint 8 - Midtrans Sandbox Integration - Next

Goal: replace or complement manual payment with Midtrans Snap Sandbox after the internal payment flow is stable.

Backlog:

- Add Midtrans config keys in `.env`: `MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, `MIDTRANS_IS_PRODUCTION=false`, `MIDTRANS_IS_SANITIZED=true`, `MIDTRANS_IS_3DS=true`.
- Install/use Midtrans PHP SDK or a small service wrapper for Snap token creation.
- Add Midtrans Snap payment option from unpaid pemesanan.
- Generate Snap token for unpaid pemesanan.
- Store Midtrans order ID, transaction ID, transaction status, fraud status, gross amount, payment type, VA number/payment code where available, and paid time in `pembayarans`.
- Add Midtrans notification/webhook route and signature verification.
- Add fallback status-check action/job if webhook cannot be used on localhost.
- On settlement/capture success: reuse Sprint 3 verification logic.
- On pending: keep pemesanan waiting.
- On deny/expire/cancel/failure: update payment status and do not reduce stock.
- Prevent duplicate stock reduction if Midtrans sends webhook more than once.
- Add tests for Snap token creation mock, webhook/status handling, successful settlement side effects, failed payment, and duplicate webhook safety.
- Document Sandbox vs Production.

Acceptance:

- User can click Midtrans payment and receive/open Snap Sandbox flow.
- Midtrans payment records are stored.
- Settlement/capture updates payment and pemesanan status.
- Stock and sold count update exactly once.
- Failed/expired/canceled payment does not reduce stock.

Production note:

- Midtrans Sandbox can be used for integration testing and PBL demo without accepting real money.
- Midtrans Production is needed to accept real customer payments and requires merchant activation. Individual/local merchants generally need owner identity documents such as KTP and NPWP; business entities need company/director legal documents and business licenses.
- Do not hardcode Midtrans keys. Store keys in `.env` and keep production server key out of git.

### Sprint 9 - Polish and Optional Scope

Goal: improve completeness after MVP.

Backlog:

- Add public homepage if required.
- Add homestay detail page.
- Add souvenir detail page.
- Add search/filter for homestay and souvenir.
- Add ulasan/rating after completed order/reservation.
- Add fasilitas and homestay_fasilitas if needed.
- Add email notification if time allows.
- Add PDF invoice only if browser print is not enough.

Acceptance:

- MVP journeys remain stable.
- Optional features do not break checkout, payment, invoice, or reservation.

## MVP Finish Criteria

Consider the project finishable for PBL demo when these flows work:

1. Admin manages homestay and souvenir.
2. Customer registers/logs in.
3. Customer sees homestay and souvenir catalog.
4. Customer buys souvenir through cart and checkout.
5. Customer uploads payment proof.
6. Admin verifies payment.
7. Souvenir stock decreases after verification.
8. Customer sees order status and invoice.
9. Customer books homestay.
10. Admin manages reservation status.
11. Admin sees simple reports.
12. Tests pass and build passes.

## Output Format

When asked to plan a sprint, return:

- Sprint name and goal.
- Backlog items.
- Acceptance criteria.
- Suggested files/tables to touch.
- Test checklist.
- Demo script.

Keep the plan practical and tied to the current Laravel codebase.
