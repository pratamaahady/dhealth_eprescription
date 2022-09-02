export default {
    toCurrency(number, prefix){
        var number_string = number.toString().replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi),
            separator = '';

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
    },
    toInt(currency) {
        if(!currency) return 0;
        return currency.toString().replace(/[^,\d]/g, '').replaceAll('.', '').replaceAll(',','.').toString();
    }
}
