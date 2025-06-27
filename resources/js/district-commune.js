    document.addEventListener("DOMContentLoaded", function () {
        const districtSelect = document.getElementById("districtSelect");
        const communeSelect = document.getElementById("communeSelect");
        const selectedCommuneId = communeSelect.dataset.selected;

        function loadCommunes(districtId, selected = null) {
            communeSelect.innerHTML = '<option value="">-- Chọn xã --</option>';
            if (!districtId) return;

            fetch(`/get-communes/${districtId}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(commune => {
                        const option = document.createElement("option");
                        option.value = commune.id;
                        option.textContent = commune.name;
                        if (selected && parseInt(selected) === commune.id) {
                            option.selected = true;
                        }
                        communeSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Lỗi load xã:", error);
                });
        }

        // Load xã khi chọn huyện
        districtSelect.addEventListener("change", function () {
            loadCommunes(this.value);
        });

        // Load sẵn nếu đã chọn huyện từ trước (ví dụ khi reload lại trang)
        if (districtSelect.value) {
            loadCommunes(districtSelect.value, selectedCommuneId);
        }
    });