@extends('layouts.mahasiswa_layouts.app')

@section('content')
    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-sm text-start">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-credit-card-2-front-fill me-2"></i>
                            {{ $page->title }}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-{{ $pembayaran->status_pembayaran === 'success' ? 'success' : 'warning' }}">
                    <i
                        class="bi bi-{{ $pembayaran->status_pembayaran === 'success' ? 'check-circle' : 'exclamation-triangle' }}-fill me-2"></i>
                    Status Pembayaran: <strong>{{ strtoupper($pembayaran->status_pembayaran) }}</strong>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-receipt me-2"></i>Detail Transaksi
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th width="40%">Order ID</th>
                                            <td width="60%">{{ $pembayaran->order_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td>
                                                @if (is_string($pembayaran->tanggal_pembayaran))
                                                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d/m/Y H:i:s') }}
                                                @else
                                                    {{ $pembayaran->tanggal_pembayaran->format('d/m/Y H:i:s') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Semester</th>
                                            <td>Semester {{ $pembayaran->semester }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $pembayaran->status_pembayaran === 'success' ? 'success' : 'warning' }}">
                                                    {{ $pembayaran->status_pembayaran }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="bi bi-cash-coin me-2"></i>Informasi Pembayaran
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th width="40%">Nominal</th>
                                            <td width="60%">
                                                <span class="badge bg-success fs-6">
                                                    Rp {{ number_format($pembayaran->ukt->nominal_ukt, 0, ',', '.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('mahasiswa.pembayaran') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
