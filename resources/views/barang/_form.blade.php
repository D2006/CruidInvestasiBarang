<div class="mb-3">
  <label for="kode_barang">Kode Barang</label>
  <input type="text" id="kode_barang" name="kode_barang"
         value="{{ old('kode_barang', $barang->kode_barang ?? '') }}"
         class="form-control @error('kode_barang') is-invalid @enderror">
  @error('kode_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="nama_barang">Nama Barang</label>
  <input type="text" id="nama_barang" name="nama_barang"
         value="{{ old('nama_barang', $barang->nama_barang ?? '') }}"
         class="form-control @error('nama_barang') is-invalid @enderror">
  @error('nama_barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="jumlah">Jumlah</label>
  <input type="number" id="jumlah" name="jumlah"
         value="{{ old('jumlah', $barang->jumlah ?? '') }}"
         class="form-control @error('jumlah') is-invalid @enderror">
  @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="satuan">Satuan</label>
  <input type="text" id="satuan" name="satuan"
         value="{{ old('satuan', $barang->satuan ?? '') }}"
         class="form-control @error('satuan') is-invalid @enderror">
  @error('satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
  <label for="lokasi">Lokasi</label>
  <input type="text" id="lokasi" name="lokasi"
         value="{{ old('lokasi', $barang->lokasi ?? '') }}"
         class="form-control @error('lokasi') is-invalid @enderror">
  @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="d-flex justify-content-between">
  <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
  <a href="{{ route('barangs.index') }}" class="btn btn-danger">Batal</a>
</div>
