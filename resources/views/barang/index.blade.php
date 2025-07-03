@extends('layouts.app')

@section('title', 'Data Inventaris Barang')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
            <h1 class="h3 mb-3 mb-md-0 text-gray-800">Data Inventaris Barang</h1>
            <div class="header-actions">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
                <a href="{{ route('barang.export.pdf') }}" class="btn btn-success">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Data Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table"></i> Daftar Inventaris Barang
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th style="min-width: 150px;">Nama Barang</th>
                                <th style="min-width: 120px;">Kategori</th>
                                <th style="min-width: 100px;">Kondisi</th>
                                <th style="min-width: 150px;">Lokasi</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat data...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="text-center py-5" style="display: none;">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data barang</h5>
                    <p class="text-muted">Klik tombol "Tambah Barang" untuk menambahkan data baru.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Barang Pertama
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="barangForm">
                    <div class="modal-body">
                        <input type="hidden" id="barangId">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_barang" class="form-label">
                                    <i class="fas fa-box"></i> Nama Barang *
                                </label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label">
                                    <i class="fas fa-tags"></i> Kategori *
                                </label>
                                <input type="text" class="form-control" id="kategori" name="kategori" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kondisi" class="form-label">
                                    <i class="fas fa-clipboard-check"></i> Kondisi *
                                </label>
                                <select class="form-select" id="kondisi" name="kondisi" required>
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lokasi_penyimpanan" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Penyimpanan *
                                </label>
                                <input type="text" class="form-control" id="lokasi_penyimpanan"
                                    name="lokasi_penyimpanan" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-trash"></i> Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data barang ini?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Data yang dihapus tidak dapat dikembalikan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let deleteId = null;

        $(document).ready(function() {
            // Setup CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Load data saat halaman dimuat
            loadData();


            $('#barangForm').submit(function(e) {
                e.preventDefault();


                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                let submitBtn = $('#submitBtn');
                let originalText = submitBtn.html();
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled',
                    true);

                let id = $('#barangId').val();
                let url = id ? `/barang/${id}` : '/barang';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addModal').modal('hide');
                        loadData();
                        showAlert('success', response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $(`#${field}`).addClass('is-invalid');
                                $(`#${field}`).siblings('.invalid-feedback').text(errors[field][
                                    0
                                ]);
                            }
                        } else {
                            showAlert('danger', 'Terjadi kesalahan saat menyimpan data.');
                        }
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Reset modal saat ditutup
            $('#addModal').on('hidden.bs.modal', function() {
                $('#barangForm')[0].reset();
                $('#barangId').val('');
                $('#modalTitle').html('<i class="fas fa-plus"></i> Tambah Barang');
                $('.form-control, .form-select').removeClass('is-invalid');
                $('.invalid-feedback').text('');
            });

            // Confirm delete
            $('#confirmDelete').click(function() {
                if (deleteId) {
                    $.ajax({
                        url: `/barang/${deleteId}`,
                        method: 'DELETE',
                        success: function(response) {
                            $('#deleteModal').modal('hide');
                            loadData();
                            showAlert('success', response.message);
                        },
                        error: function() {
                            showAlert('danger', 'Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            });
        });

        function loadData() {

            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().clear().destroy();
            }

            $.get('/barang/data', function(response) {
                let tbody = $('#dataTable tbody');
                tbody.empty();

                if (response.data.length === 0) {
                    $('#emptyState').show();
                    $('#dataTable').hide();
                } else {
                    $('#emptyState').hide();
                    $('#dataTable').show();

                    $.each(response.data, function(index, item) {
                        let kondisiClass = item.kondisi === 'Baik' ? 'success' :
                            item.kondisi === 'Rusak Ringan' ? 'warning' : 'danger';
                        let kondisiIcon = item.kondisi === 'Baik' ? 'check-circle' :
                            item.kondisi === 'Rusak Ringan' ? 'exclamation-triangle' : 'times-circle';

                        tbody.append(`
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td><strong>${item.nama_barang}</strong></td>
                        <td>
                            <span class="badge bg-secondary">
                                <i class="fas fa-tag"></i> ${item.kategori}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-${kondisiClass}">
                                <i class="fas fa-${kondisiIcon}"></i> ${item.kondisi}
                            </span>
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt text-muted"></i> ${item.lokasi_penyimpanan}
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-warning" onclick="editBarang(${item.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteBarang(${item.id})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
                    });


                    $('#dataTable').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                        }
                    });
                }
            }).fail(function() {
                showAlert('danger', 'Gagal memuat data. Silakan refresh halaman.');
            });
        }

        function editBarang(id) {
            $.get(`/barang/${id}`, function(response) {
                let data = response.data;
                $('#barangId').val(data.id);
                $('#nama_barang').val(data.nama_barang);
                $('#kategori').val(data.kategori);
                $('#kondisi').val(data.kondisi);
                $('#lokasi_penyimpanan').val(data.lokasi_penyimpanan);
                $('#modalTitle').html('<i class="fas fa-edit"></i> Edit Barang');
                $('#addModal').modal('show');
            }).fail(function() {
                showAlert('danger', 'Gagal memuat data barang.');
            });
        }

        function deleteBarang(id) {
            deleteId = id;
            $('#deleteModal').modal('show');
        }

        function showAlert(type, message) {
            let alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

            $('#alertContainer').html(alertHtml);

            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }
    </script>

    <link rel="stylesheet" href="{{ asset('assets/DataTables-1.13.3/css/dataTables.bootstrap5.css') }}">
    <script src="{{ asset('assets/DataTables-1.13.3/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/DataTables-1.13.3/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection
