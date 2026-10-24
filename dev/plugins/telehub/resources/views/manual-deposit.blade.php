@extends('core/base::layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="main-form">
                <div class="form-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Xử lý yêu cầu nạp tiền thủ công</h4>

                            @if(session('success_msg'))
                                <div class="alert alert-success">
                                    {{ session('success_msg') }}
                                </div>
                            @endif

                            @if(session('error_msg'))
                                <div class="alert alert-danger">
                                    {{ session('error_msg') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('telehub.manual-deposit.process') }}" method="POST">
                                @csrf

                                @if(count($tenants) > 0)
                                    <div class="form-group mb-3">
                                        <label for="tenant_id" class="control-label">Tenant (Chỉ dành cho Super Admin)</label>
                                        <select name="tenant_id" id="tenant_id" class="form-control">
                                            <option value="">-- Chọn Tenant (Nếu biết) --</option>
                                            @foreach($tenants as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Bỏ qua nếu mã giao dịch là duy nhất.</small>
                                    </div>
                                @endif

                                <div class="form-group mb-3 required">
                                    <label for="payment_code" class="control-label required">Mã giao dịch / Nội dung CK</label>
                                    <input type="text" name="payment_code" id="payment_code" class="form-control" required placeholder="Ví dụ: ESJ9X8ZUEUHY" value="{{ old('payment_code') }}">
                                    <small class="text-muted">Nhập chính xác mã được tạo trong yêu cầu nạp tiền.</small>
                                </div>

                                <div class="form-group mb-4 required">
                                    <label for="amount" class="control-label required">Số tiền thực nhận (VND)</label>
                                    <input type="number" name="amount" id="amount" class="form-control" required min="1" placeholder="Ví dụ: 50000" value="{{ old('amount') }}">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-check-circle"></i> Xử lý & Cộng tiền
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
