<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script type="text/javascript">
    window.onload = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){ window.location.href = '/'; },
            onPending: function(result){ alert("Menunggu pembayaran..."); },
            onError: function(result){ alert("Pembayaran gagal."); },
            onClose: function(){ alert("Kamu menutup pembayaran."); }
        });
    };
</script>
