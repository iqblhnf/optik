<div class="card border-{{ $color }} mb-3">
  <div class="card-header bg-{{ $color }} text-white">{{ $judul }}</div>
  <div class="card-body p-2">
    <table class="table table-sm table-bordered mb-0">
      <tr>
        <th>SPH</th><td>{{ $pemeriksaan->{$prefix.'_sph'} ?? '-' }}</td>
        <th>CYL</th><td>{{ $pemeriksaan->{$prefix.'_cyl'} ?? '-' }}</td>
        <th>AXIS</th><td>{{ $pemeriksaan->{$prefix.'_axis'} ?? '-' }}</td>
      </tr>
      <tr>
        <th>PRISMA</th><td>{{ $pemeriksaan->{$prefix.'_prisma'} ?? '-' }}</td>
        <th>BASE</th><td>{{ $pemeriksaan->{$prefix.'_base'} ?? '-' }}</td>
        <th>ADD</th><td>{{ $pemeriksaan->{$prefix.'_add'} ?? '-' }}</td>
      </tr>
    </table>
  </div>
</div>
