@extends('landing')

@section('title_menu', 'Outlet')

@section('isikonten')

@push('styles')
  {{-- Memanggil file CSS terpisah --}}
  <link rel="stylesheet" href="{{ asset('bs/css/silam-layout.css') }}">
@endpush

<div class="container my-4">
    <div class="tracking-hero-card">
    <!-- Gelembung Dekorasi Latar Belakang -->
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    <div class="bubble bubble-4"></div>
    <div class="bubble bubble-5"></div>
    <div class="bubble bubble-6"></div>
    <div class="bubble bubble-7"></div>
    <div class="bubble bubble-8"></div>

    <!-- Judul Sesuai Desain Mockup -->
    <h1 class="tracking-hero-title">
      Lacak Pesananmu secara real-time!<br>
      Dengan memasukan nomor resi atau nomor HP.
    </h1>

        <div class="tracking-search-box-wrap"><form action="{{ url()->current() }}" method="GET">
            <div class="tracking-input-pill">
                <input type="text" name="order_number" placeholder="Masukan Nomor Pesanan"
                    value="{{ request('order_number') }}" autocomplete="off" required>
                <button type="submit" class="btn-search-bubble" aria-label="Cari Resi">
                    <i class="bi bi-search"></i>
                </button>
                </div>
            </form>
        </div>
  </div>

  <!-- ========================================================
       2. HASIL STATUS CUCIAN & TIMELINE REAL-TIME
       ======================================================== -->
  @php
    $searchKey = request('order_number', 'SLM-2026-9021');
    $currentStep = ($searchKey === 'SLM-2026-8804') ? 5 : 4;

    // Memakai objek $order dari Controller jika ada, atau fallback data simulasi
    $orderData = $order ?? (object)[
      'order_number'    => strtoupper($searchKey),
      'created_at_text' => 'Hari Ini, 09:15 WIB',
      'customer_name'   => 'Ahmad Syahrul',
      'service_name'    => 'Cuci Kering Setrika',
      'weight'          => '4.2 Kg',
      'total_price'     => 'Rp 29.400',
      'estimate'        => 'Hari Ini, 16:30 WIB',
      'status'          => ($currentStep === 5) ? 'Siap Diambil' : 'Sedang Diproses',
      'current_step'    => $currentStep, // 1 s.d 5
    ];
  @endphp

  @if(request()->has('order_number') || isset($order))
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="status-result-card">

          <!-- Header Hasil Resi -->
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 border-bottom">
            <div>
              <h4 class="fw-bold mb-1" style="color: var(--navy-main);">Resi: {{ $orderData->order_number }}</h4>
              <div class="text-muted small">Waktu Penerimaan: <span>{{ $orderData->created_at_text }}</span></div>
            </div>
            <div>
              @if($orderData->current_step >= 5)
                <span class="status-badge-pill badge-ready-green">
                  <i class="bi bi-check-circle-fill"></i> Siap Diambil
                </span>
              @else
                <span class="status-badge-pill badge-progress-blue">
                  <i class="bi bi-arrow-repeat"></i> Sedang Diproses (In Progress)
                </span>
              @endif
            </div>
          </div>

          <!-- Rincian Pesanan (Grid Informasi) -->
          <div class="order-info-box">
            <div class="row g-3">
              <div class="col-6 col-md-3">
                <div class="order-info-label">Nama Pelanggan</div>
                <div class="order-info-value">{{ $orderData->customer_name }}</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="order-info-label">Paket Layanan</div>
                <div class="order-info-value">{{ $orderData->service_name }}</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="order-info-label">Berat & Biaya</div>
                <div class="order-info-value">{{ $orderData->weight }} ({{ $orderData->total_price }})</div>
              </div>
              <div class="col-6 col-md-3">
                <div class="order-info-label">Estimasi Selesai</div>
                <div class="order-info-value text-primary">{{ $orderData->estimate }}</div>
              </div>
            </div>
          </div>

          <!-- 5 Tahapan Progres Cucian (SOP SILAM) -->
          <h6 class="fw-bold mt-4 mb-3" style="color: var(--navy-main);">
            <i class="bi bi-clock-history me-1 text-primary"></i> Progres Tahapan Cucian Real-Time
          </h6>

          <div class="laundry-timeline">
            <!-- Tahap 1 -->
            <div class="timeline-step-item {{ $orderData->current_step > 1 ? 'is-done' : ($orderData->current_step == 1 ? 'is-active' : '') }}">
              <div class="timeline-circle">
                @if($orderData->current_step > 1) <i class="bi bi-check-lg"></i> @else 1 @endif
              </div>
              <div class="timeline-heading">1. Penimbangan & Terbit Nota Digital</div>
              <div class="timeline-subtext">Pakaian ditimbang transparan di kasir Ath_hura dan nota otomatis dikirim via WhatsApp. (09:18 WIB)</div>
            </div>

            <!-- Tahap 2 -->
            <div class="timeline-step-item {{ $orderData->current_step > 2 ? 'is-done' : ($orderData->current_step == 2 ? 'is-active' : '') }}">
              <div class="timeline-circle">
                @if($orderData->current_step > 2) <i class="bi bi-check-lg"></i> @else 2 @endif
              </div>
              <div class="timeline-heading">2. Proses Pencucian Higienis</div>
              <div class="timeline-subtext">Dicuci bersih dengan takaran deterjen khusus kain dan pewangi tahan lama. (10:05 WIB)</div>
            </div>

            <!-- Tahap 3 -->
            <div class="timeline-step-item {{ $orderData->current_step > 3 ? 'is-done' : ($orderData->current_step == 3 ? 'is-active' : '') }}">
              <div class="timeline-circle">
                @if($orderData->current_step > 3) <i class="bi bi-check-lg"></i> @else 3 @endif
              </div>
              <div class="timeline-heading">3. Pengeringan Mesin Suhu Terkontrol</div>
              <div class="timeline-subtext">Pakaian dikeringkan tuntas dengan mesin komersial, bebas debu & higienis. (11:20 WIB)</div>
            </div>

            <!-- Tahap 4 -->
            <div class="timeline-step-item {{ $orderData->current_step > 4 ? 'is-done' : ($orderData->current_step == 4 ? 'is-active' : '') }}">
              <div class="timeline-circle">
                @if($orderData->current_step > 4)
                  <i class="bi bi-check-lg"></i>
                @elseif($orderData->current_step == 4)
                  <i class="bi bi-fire"></i>
                @else
                  4
                @endif
              </div>
              <div class="timeline-heading">
                4. Penyetrikaan Uap & Pelipatan Rapi
                @if($orderData->current_step == 4) <span class="badge bg-primary-subtle text-primary ms-1">Sedang Berjalan</span> @endif
              </div>
              <div class="timeline-subtext">Pakaian disetrika uap profesional agar halus licin tanpa merusak serat kain.</div>
            </div>

            <!-- Tahap 5 -->
            <div class="timeline-step-item {{ $orderData->current_step >= 5 ? 'is-done is-active' : '' }}">
              <div class="timeline-circle">
                @if($orderData->current_step >= 5) <i class="bi bi-box-seam"></i> @else 5 @endif
              </div>
              <div class="timeline-heading">5. Siap Diambil / Diantar</div>
              <div class="timeline-subtext">Pakaian dipacking rapi dan notifikasi WhatsApp siap ambil terkirim otomatis ke HP Anda.</div>
            </div>
          </div>

          <!-- Tombol Aksi Cetak & WhatsApp -->
          <div class="d-flex flex-wrap gap-2 justify-content-end mt-4 pt-3 border-top">
            <button class="btn btn-outline-secondary rounded-pill btn-sm px-3" onclick="window.print()">
              <i class="bi bi-printer me-1"></i> Cetak Bukti Status
            </button>
            <a href="https://wa.me/6282119793595?text=Halo%20SILAM,%20saya%20ingin%20konfirmasi%20resi%20{{ $orderData->order_number }}" target="_blank" class="btn btn-success rounded-pill btn-sm px-4">
              <i class="bi bi-whatsapp me-1"></i> Hubungi CS Outlet
            </a>
          </div>

        </div>
      </div>
    </div>
  @endif

</div>

@endsection

