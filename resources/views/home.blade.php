@extends('layouts.app')

@section('title', 'BoF Careers')

@section('content')
<style>
  /* ====== Layout persis seperti screenshot ====== */
  body{ background:#f6f7fb; }
  .hero-container{
    /* lebar konten tengah seperti gambar */
    max-width: 1150px;           /* tweak kecil kalau perlu 1120–1180 */
    margin-inline: auto;
    padding-top: 56px;           /* jarak dari navbar */
    padding-bottom: 48px;
  }
  .hero-row{
    display: grid;
    grid-template-columns: 1fr 460px;  /* kiri konten, kanan gambar */
    gap: 36px;
    align-items: start;
  }

  /* Kiri */
  .hero-title{
    font-size: 64px;             /* ukuran “BoF Careers” pada gambar */
    font-weight: 600;
    letter-spacing: .2px;
    color: #111827;
    margin: 0 0 18px 0;
    line-height: 1.05;
  }
  .hero-desc{
    font-size: 18px;
    line-height: 1.85;
    color: #6b7280;              /* abu-abu halus */
    max-width: 650px;            /* panjang paragraf persis */
    margin: 0;
  }

  /* Kanan (kartu gambar) */
  .hero-card{
    background:#fff;
    border-radius: 14px;
    box-shadow: 0 6px 18px rgba(17,24,39,.08);
    padding: 0;                  /* sesuai gambar: tanpa padding, hanya radius */
    overflow: hidden;
    /* posisi turun sedikit dari atas seperti screenshot */
    margin-top: 10px;
  }
  .hero-img{
    display:block;
    width: 100%;
    height: 520px;               /* tinggi persis agar proporsinya sama */
    object-fit: cover;
    object-position: center;
  }

  /* Responsif biar tetap cantik di layar kecil (opsional) */
  @media (max-width: 992px){
    .hero-container{ padding-top: 32px; }
    .hero-row{ grid-template-columns: 1fr; }
    .hero-title{ font-size: 44px; }
    .hero-img{ height: 380px; }
  }
</style>

<div class="hero-container">
  <div class="hero-row">
    <!-- Kiri -->
    <div>
      <h1 class="hero-title">BoF Careers</h1>
      <p class="hero-desc">
        Temukan Karir Impianmu di Dunia Fashion melalui Platform yang menyediakan peluang terbaik!
      </p>
    </div>

    <!-- Kanan -->
    <div class="hero-card">
      {{-- Simpan file di: public/images/fashion-model.jpg --}}
      <img src="{{ asset('images/fashion-model.jpg') }}" alt="BoF Careers" class="hero-img">
    </div>
  </div>
</div>


@endsection
