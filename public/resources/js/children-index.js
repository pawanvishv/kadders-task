let selectedContacts = {};
let table;
let selectedIds;
$(function () {
    // Initialize DataTable
    if ($.fn.DataTable.isDataTable('#parents-table')) {
        $('#parents-table').DataTable().destroy();
    }
    $(document).ready(function () {
        $("#parents-table").DataTable({
            ajax: "children",
            columns: [
                { data: "id" },
                { data: "first_name" },
                { data: "last_name" },
                { data: "email" },
                { data: "action" }
            ],
        });
    });

    // Event delegation
    $(document)
        .on("change", ".row-checkbox", function () {
            const id = $(this).data("id");
            selectedContacts[id] = this.checked;
        })
        .on("click", "#delete-contacts", function () {
            const url = this.dataset.url;
            if (!url) return;

            // SweetAlert2 confirmation
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(url)
                        .then((res) => {
                            Swal.fire(
                                "Deleted!",
                                res.data.message || "Contact deleted.",
                                "success"
                            );
                            table.ajax.reload();
                        })
                        .catch((err) => {
                            Swal.fire(
                                "Error!",
                                err.response?.data?.message || "Delete failed.",
                                "error"
                            );
                        });
                }
            });
        })
        .on("click", ".row-checkbox", () => {
            selectedIds = $(".row-checkbox:checked")
                .map(function () {
                    return $(this).data("id");
                })
                .get();
        });
});
