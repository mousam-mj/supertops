@extends('admin.layout')

@section('title', 'Customize')
@section('page-title', 'Customizer')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row mb-3">
    <div class="col-12">
        <h4 class="mb-1 fw-bold" style="color: #2d3748;">Customize</h4>
        <p class="text-muted mb-0">Single public customizer at <code>/customize</code>. Title, part colors, sizes and prices are stored here only — not linked to catalog products.</p>
    </div>
</div>

@if(!$hasGlobalSaved)
    <div class="alert alert-info mb-3">
        No settings saved yet — use the tabs below, then click <strong>Save</strong>.
    </div>
@endif

<form action="{{ route('admin.customize.update') }}" method="post" id="admin-customize-form">
    @csrf
    @method('PUT')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @php
        $paletteMeta = [
            'bottle' => ['id' => 'tab-body', 'label' => 'Body', 'field' => 'palette_bottle', 'icon' => 'bi-circle'],
            'cap' => ['id' => 'tab-lid', 'label' => 'Lid ring', 'field' => 'palette_cap', 'icon' => 'bi-record-circle'],
            'strap' => ['id' => 'tab-straw', 'label' => 'Straw', 'field' => 'palette_strap', 'icon' => 'bi-droplet'],
            'handle' => ['id' => 'tab-handle', 'label' => 'Handle', 'field' => 'palette_handle', 'icon' => 'bi-grip-vertical'],
            'boot' => ['id' => 'tab-base', 'label' => 'Bottom base', 'field' => 'palette_boot', 'icon' => 'bi-disc'],
        ];
    @endphp

    <div class="card card-customize-settings shadow-sm border-0 mb-3">
        <div class="card-header card-header-customize-tabs border-bottom py-2 px-0">
            <ul class="nav nav-tabs nav-tabs-custom flex-nowrap px-2" id="customizeAdminTabs" role="tablist" style="overflow-x:auto;flex-wrap:nowrap;white-space:nowrap;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-general-btn" data-bs-toggle="tab" data-bs-target="#tab-general" type="button" role="tab" aria-controls="tab-general" aria-selected="true">
                        <i class="bi bi-tag me-1"></i>Title &amp; pricing
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-sizes-btn" data-bs-toggle="tab" data-bs-target="#tab-sizes" type="button" role="tab" aria-controls="tab-sizes" aria-selected="false">
                        <i class="bi bi-rulers me-1"></i>Sizes &amp; prices
                    </button>
                </li>
                @foreach($paletteMeta as $key => $meta)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="{{ $meta['id'] }}-btn" data-bs-toggle="tab" data-bs-target="#{{ $meta['id'] }}" type="button" role="tab" aria-controls="{{ $meta['id'] }}" aria-selected="false">
                        <i class="bi {{ $meta['icon'] }} me-1"></i>{{ $meta['label'] }}
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="customizeAdminTabContent">
                <div class="tab-pane fade show active" id="tab-general" role="tabpanel" aria-labelledby="tab-general-btn" tabindex="0">
                    <div class="row g-3">
                        <div class="col-md-8 col-lg-6">
                            <label class="form-label">Customizer title</label>
                            <input type="text" name="display_name" class="form-control" value="{{ old('display_name', $displayName) }}" placeholder="Customize">
                            <small class="text-muted">Shown on the public customizer (default: &ldquo;Customize&rdquo; if left blank).</small>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-sizes" role="tabpanel" aria-labelledby="tab-sizes-btn" tabindex="0">
                    <p class="text-muted small">Each row is one size card on the customizer. Price is in ₹.</p>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead><tr><th>Name</th><th>Description</th><th style="width:9rem">Price (₹)</th><th class="text-end" style="width:4rem"> </th></tr></thead>
                            <tbody id="customize-sizes-tbody" class="customize-repeatable-tbody" data-input-prefix="sizes">
                                @foreach($sizesRows as $i => $row)
                                    <tr>
                                        <td><input type="text" class="form-control form-control-sm" name="sizes[{{ $i }}][name]" value="{{ old('sizes.'.$i.'.name', $row['name']) }}" placeholder="e.g. 40 oz"></td>
                                        <td><input type="text" class="form-control form-control-sm" name="sizes[{{ $i }}][desc]" value="{{ old('sizes.'.$i.'.desc', $row['desc']) }}" placeholder="Short line"></td>
                                        <td><input type="number" step="0.01" min="0" class="form-control form-control-sm" name="sizes[{{ $i }}][price]" value="{{ old('sizes.'.$i.'.price', $row['price']) }}" placeholder="0"></td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger customize-row-delete" title="Delete row"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 customize-add-row" data-tbody="customize-sizes-tbody"><i class="bi bi-plus-lg me-1"></i>Add more</button>
                </div>

                @foreach($paletteMeta as $key => $meta)
                <div class="tab-pane fade" id="{{ $meta['id'] }}" role="tabpanel" aria-labelledby="{{ $meta['id'] }}-btn" tabindex="0">
                    <p class="text-muted small mb-3">Colors for <strong>{{ $meta['label'] }}</strong> on the public customizer.</p>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead><tr><th style="width:42%">Name</th><th>Hex</th><th class="text-end" style="width:4rem"> </th></tr></thead>
                            <tbody id="customize-palette-{{ $key }}-tbody" class="customize-repeatable-tbody" data-input-prefix="{{ $meta['field'] }}">
                                @foreach($paddedPalettes[$key] as $i => $c)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="{{ $meta['field'] }}[{{ $i }}][name]" value="{{ old($meta['field'].'.'.$i.'.name', $c['name']) }}" placeholder="Color name">
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 align-items-center">
                                                <input type="text" class="form-control form-control-sm" name="{{ $meta['field'] }}[{{ $i }}][hex]" value="{{ old($meta['field'].'.'.$i.'.hex', $c['hex']) }}" placeholder="#000000" maxlength="7" style="max-width:7rem">
                                                <input type="color" class="form-control form-control-color" value="{{ strlen(old($meta['field'].'.'.$i.'.hex', $c['hex'])) >= 4 ? old($meta['field'].'.'.$i.'.hex', $c['hex']) : '#888888' }}" title="Pick" data-sync-hex="{{ $meta['field'] }}_{{ $i }}">
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger customize-row-delete" title="Delete row"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 customize-add-row" data-tbody="customize-palette-{{ $key }}-tbody"><i class="bi bi-plus-lg me-1"></i>Add more</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-5">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Save customizer settings</button>
        <a href="{{ route('customize') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary">Open public customizer</a>
    </div>
</form>

<style>
/* Override global admin .card-header (gradient + white text) — tabs need dark text on light bar */
.card-customize-settings .card-header-customize-tabs {
    background: #e8eef7 !important;
    background-image: none !important;
    color: #0f172a !important;
    padding: 0.5rem 0.25rem 0 !important;
    font-weight: 500;
    border-color: #cbd5e1 !important;
}
.card-customize-settings .card-header-customize-tabs .nav-link {
    border: none !important;
    border-radius: 8px 8px 0 0 !important;
    color: #334155 !important;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.65rem 1rem !important;
    margin-bottom: 0;
    background: transparent !important;
}
.card-customize-settings .card-header-customize-tabs .nav-link:hover {
    color: #0f172a !important;
    background: rgba(255, 255, 255, 0.75) !important;
}
.card-customize-settings .card-header-customize-tabs .nav-link.active {
    color: #fff !important;
    font-weight: 600;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
    box-shadow: 0 2px 8px rgba(30, 64, 175, 0.25);
}
.card-customize-settings .card-header-customize-tabs .nav-link i {
    opacity: 0.95;
}
.card-customize-settings .card-body {
    background: #fff;
    border-radius: 0 0 15px 15px;
}
</style>
<script>
(function () {
    var form = document.getElementById('admin-customize-form');
    if (!form) return;

    function escRe(s) {
        return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function reindexTbody(tbody) {
        var prefix = tbody.getAttribute('data-input-prefix');
        if (!prefix) return;
        var re = new RegExp('^' + escRe(prefix) + '\\[\\d+\\]');
        tbody.querySelectorAll('tr').forEach(function (tr, i) {
            tr.querySelectorAll('input[name]').forEach(function (inp) {
                inp.name = inp.name.replace(re, prefix + '[' + i + ']');
            });
            tr.querySelectorAll('input[type="color"][data-sync-hex]').forEach(function (p) {
                p.setAttribute('data-sync-hex', prefix + '_' + i);
            });
        });
    }

    function bindHexPickerRow(tr) {
        if (tr._hexRowBound) return;
        var picker = tr.querySelector('input[type="color"][data-sync-hex]');
        var text = tr.querySelector('input[name*="[hex]"]');
        if (!picker || !text) return;
        tr._hexRowBound = true;
        picker.addEventListener('input', function () { text.value = picker.value; });
        text.addEventListener('input', function () {
            var v = (text.value || '').trim();
            if (/^#?[0-9A-Fa-f]{6}$/.test(v)) {
                picker.value = v.charAt(0) === '#' ? v : '#' + v;
            }
        });
    }

    function clearRowInputs(tr) {
        tr.querySelectorAll('input').forEach(function (inp) {
            if (inp.type === 'color') inp.value = '#888888';
            else if (inp.type === 'number') inp.value = '';
            else inp.value = '';
        });
    }

    form.querySelectorAll('.customize-repeatable-tbody tr').forEach(bindHexPickerRow);

    form.addEventListener('click', function (e) {
        var del = e.target.closest('.customize-row-delete');
        if (del) {
            var tr = del.closest('tr');
            var tbody = tr && tr.closest('.customize-repeatable-tbody');
            if (!tbody || !tr) return;
            var rows = tbody.querySelectorAll('tr');
            if (rows.length <= 1) {
                alert('At least one row is required.');
                return;
            }
            tr.remove();
            reindexTbody(tbody);
            e.preventDefault();
            return;
        }
        var add = e.target.closest('.customize-add-row');
        if (add) {
            var id = add.getAttribute('data-tbody');
            var tbody = id && document.getElementById(id);
            if (!tbody) return;
            var last = tbody.querySelector('tr:last-child');
            if (!last) return;
            var clone = last.cloneNode(true);
            delete clone._hexRowBound;
            clearRowInputs(clone);
            tbody.appendChild(clone);
            reindexTbody(tbody);
            bindHexPickerRow(clone);
            e.preventDefault();
        }
    });
})();
@php
    $adminCustomizeErrorTab = 'tab-general-btn';
    if ($errors->has('sizes')) {
        $adminCustomizeErrorTab = 'tab-sizes-btn';
    }
@endphp
@if($errors->any())
document.addEventListener('DOMContentLoaded', function(){
    var errBtn = document.getElementById(@json($adminCustomizeErrorTab));
    if (errBtn && typeof bootstrap !== 'undefined' && bootstrap.Tab) {
        new bootstrap.Tab(errBtn).show();
    }
});
@endif
</script>
@endsection
