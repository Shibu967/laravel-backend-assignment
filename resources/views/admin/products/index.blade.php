@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-lg font-semibold">Products</h4>

                        <div class="space-x-2">
                            <a href="javascript:void(0);" id="openCreateModal"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                Create
                            </a>


                            <a href="javascript:void(0);" id="openImportModal"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                CSV Import
                            </a>

                        </div>
                    </div>

                    <table id="products" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Product Modal -->
    <div id="createProductModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl max-h-[80vh] overflow-y-auto">           
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Create Product</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
            </div>
            <form id="createProductForm" class="px-6 py-6 space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Product Name">
                        <span class="text-red-500 text-sm error-text" id="name_error"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="₹ Price">
                        <span class="text-red-500 text-sm error-text" id="price_error"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Available Stock">
                        <span class="text-red-500 text-sm error-text" id="stock_error"></span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id"
                            class="mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Category</option>
                        </select>
                        <span class="text-red-500 text-sm error-text" id="category_id_error"></span>
                    </div>

                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3"
                        class="mt-1 w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Product description"></textarea>
                    <span class="text-red-500 text-sm error-text" id="description_error"></span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="mt-1 w-full rounded-md border-gray-300 p-2">
                    <span class="text-red-500 text-sm error-text" id="image_error"></span>

                    <!-- Preview -->
                    <div id="imagePreview" class="mt-3 hidden">
                        <img id="previewImg" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" id="cancelBtn"
                        class="px-5 py-2 rounded-md bg-gray-500 text-white hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" id="submitBtn"
                        class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 flex items-center justify-center gap-2">
                        <span class="btn-text">Save Product</span>
                        <svg id="btnLoader" class="w-5 h-5 animate-spin text-white hidden"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-1/3">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Edit Product</h3>
            </div>
            <form id="editProductForm" class="px-6 py-4">
                @csrf
                <input type="hidden" id="edit_product_id">
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="edit_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Product Name">
                    <span class="text-red-500 text-sm mt-1 error-text" id="edit_name_error"></span>
                </div>
                <div class="mb-4">
                    <label for="edit_price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="edit_price"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Product Price">
                    <span class="text-red-500 text-sm mt-1 error-text" id="edit_price_error"></span>
                </div>
                <div class="mb-4">
                    <label for="edit_stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="edit_stock"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Product Stock">
                    <span class="text-red-500 text-sm mt-1 error-text" id="edit_stock_error"></span>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="closeEditModal"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    <div id="importModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Import Products (CSV)</h2>
                <button onclick="closeImportModal()" class="text-gray-500 hover:text-gray-700 text-xl">
                    ✕
                </button>
            </div>
            <input type="file" id="csv_file" accept=".csv" class="w-full border rounded px-3 py-2 mb-4">
            <button id="importBtn" onclick="startImport()"
                class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700 font-medium transition flex items-center justify-center gap-2">               
                <svg id="importBtnLoader" class="w-5 h-5 animate-spin text-white hidden"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span id="importBtnText">Start Import</span>
            </button>
            <div id="progressSection" class="mt-6 hidden">
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Progress</span>
                        <span id="progressPercent">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                        <div id="progressBar" class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                            style="width: 0%"></div>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between p-2 bg-gray-50 rounded">
                        <span class="text-gray-600">Status:</span>
                        <span id="statusText" class="font-medium text-blue-600">Starting...</span>
                    </div>

                    <div class="flex justify-between p-2 bg-gray-50 rounded">
                        <span class="text-gray-600">Total Rows:</span>
                        <span id="totalRows" class="font-medium">-</span>
                    </div>

                    <div class="flex justify-between p-2 bg-green-50 rounded">
                        <span class="text-gray-600">Processed:</span>
                        <span id="processedRows" class="font-medium text-green-600">0</span>
                    </div>

                    <div class="flex justify-between p-2 bg-yellow-50 rounded">
                        <span class="text-gray-600">Remaining:</span>
                        <span id="remainingRows" class="font-medium text-yellow-600">-</span>
                    </div>

                    <div id="skippedSection" class="flex justify-between p-2 bg-red-50 rounded hidden">
                        <span class="text-gray-600">Skipped/Failed:</span>
                        <span id="skippedRows" class="font-medium text-red-600">0</span>
                    </div>
                </div>
                <div id="completionMessage" class="mt-4 p-3 rounded hidden"></div>
            </div>
        </div>
    </div>
@endsection
<style>
    #progressBar {
        transition: width 0.3s ease-in-out;
    }
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    #statusText.text-blue-600 {
        animation: pulse 2s infinite;
    }
</style>
@push('scripts')
    <script>
        $(function() {
            $('#products').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.products.datatable') }}",
                searching: false,
                lengthChange: false,
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'price'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'category_name'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'id',
                        render: function(id) {
                            return `
                        <button onclick="openEditModal(${id})" 
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700">
                            Edit
                        </button>
                        <button onclick="deleteProduct(${id})" 
                            class="ml-2 inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                            Delete
                        </button>
                    `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        function deleteProduct(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/products/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: res.message || 'Product deleted successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#products').DataTable().ajax.reload();
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete!'
                            });
                        }
                    });
                }
            });
        }
        $('#openCreateModal').click(function() {
            $('#createProductModal').removeClass('hidden');
            $('#createProductForm')[0].reset();
            $('#imagePreview').addClass('hidden');
            $('#previewImg').attr('src', '');
            $('.error-text').text('');
            loadCategories();
        });

        // Load Categories
        function loadCategories() {
            $.ajax({
                url: "{{ route('admin.categories.index') }}",
                type: 'GET',
                success: function(res) {
                    let options = '<option value="">Select Category</option>';
                    res.data.forEach(function(cat) {
                        options += `<option value="${cat.id}">${cat.name}</option>`;
                    });
                    $('#category_id').html(options);
                },
                error: function() {
                    Swal.fire('Error', 'Unable to load categories', 'error');
                }
            });
        }

        // Close Modal
        $('#closeModal').click(function() {
            $('#createProductModal').addClass('hidden');
        });

        // Clear errors on input
        $('#name, #price, #stock, #category_id, #description').on('input change', function() {
            let id = $(this).attr('id');
            $('#' + id + '_error').text('');
        });

        $('#image').on('change', function() {
            $('#image_error').text('');
        });



        // Image Preview
        $('#image').on('change', function(e) {
            $('#image_error').text(''); // clear error

            const file = e.target.files[0];

            if (file) {
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (!validTypes.includes(file.type)) {
                    $('#image_error').text('Image must be jpeg, png, jpg or gif');
                    $(this).val('');
                    $('#imagePreview').addClass('hidden');
                    return;
                }

                if (file.size > maxSize) {
                    $('#image_error').text('Image size must be less than 2MB');
                    $(this).val('');
                    $('#imagePreview').addClass('hidden');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').removeClass('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').addClass('hidden');
            }
        });


        $('#createProductForm').submit(function(e) {
            e.preventDefault();
            $('.error-text').text('');

            // ✅ Form fields
            let form = $(this);
            let formData = new FormData(this);

            // ✅ Individual field values (optional, for validation)
            let name = form.find('input[name="name"]').val().trim();
            let price = form.find('input[name="price"]').val().trim();
            let stock = form.find('input[name="stock"]').val().trim();
            let category_id = form.find('select[name="category_id"]').val();
            let description = form.find('textarea[name="description"]').val().trim();
            let imageFile = form.find('input[name="image"]')[0]?.files[0];

            let hasError = false;

            if (name === '') {
                $('#name_error').text('Name is required');
                hasError = true;
            }
            if (price === '' || isNaN(price) || price < 0) {
                $('#price_error').text('Valid price is required');
                hasError = true;
            }
            if (stock === '' || isNaN(stock) || stock < 0) {
                $('#stock_error').text('Valid stock is required');
                hasError = true;
            }
            if (!category_id) {
                $('#category_id_error').text('Category is required');
                hasError = true;
            }
            if (description === '') {
                $('#description_error').text('Description is required');
                hasError = true;
            }
            if (!imageFile) {
                $('#image_error').text('Product image is required');
                hasError = true;
            }

            if (hasError) return;

            // ✅ Show loader, disable button
            let submitBtn = $('#submitBtn');
            let btnText = submitBtn.find('.btn-text');
            let btnLoader = $('#btnLoader');

            submitBtn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');
            btnText.text('Saving...');
            btnLoader.removeClass('hidden');

            $.ajax({
                url: "{{ route('admin.products.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $('#createProductModal').addClass('hidden');
                    $('#createProductForm')[0].reset();
                    $('#imagePreview').addClass('hidden');
                    $('#products').DataTable().ajax.reload();

                    // ✅ Reset button state
                    resetButton();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong!', 'error');
                    }

                    // ✅ Reset button state on error
                    resetButton();
                }
            });

            // ✅ Helper function to reset button
            function resetButton() {
                submitBtn.prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                btnText.text('Save Product');
                btnLoader.addClass('hidden');
            }
        });



        function openEditModal(id) {
            $.ajax({
                url: `/admin/products/${id}/edit`, // create edit route in controller
                type: 'GET',
                success: function(res) {
                    $('#edit_product_id').val(res.id);
                    $('#edit_name').val(res.name);
                    $('#edit_price').val(res.price);
                    $('#edit_stock').val(res.stock);
                    $('.error-text').text('');
                    $('#editProductModal').removeClass('hidden');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch product data!'
                    });
                }
            });
        }


        $('#closeEditModal').click(function() {
            $('#editProductModal').addClass('hidden');
        });


        $('#edit_name, #edit_price, #edit_stock').on('input', function() {
            let id = $(this).attr('id');
            $(`#${id}_error`).text('');
        });


        $('#editProductForm').submit(function(e) {
            e.preventDefault();
            $('.error-text').text('');

            let id = $('#edit_product_id').val();
            let name = $('#edit_name').val().trim();
            let price = $('#edit_price').val().trim();
            let stock = $('#edit_stock').val().trim();


            let hasError = false;
            if (name === '') {
                $('#edit_name_error').text('Name is required');
                hasError = true;
            }
            if (price === '' || isNaN(price) || Number(price) < 0) {
                $('#edit_price_error').text('Price must be a positive number');
                hasError = true;
            }
            if (stock === '' || !Number.isInteger(Number(stock)) || Number(stock) < 0) {
                $('#edit_stock_error').text('Stock must be a positive integer');
                hasError = true;
            }
            if (hasError) return;

            $.ajax({
                url: `/admin/products/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    name: name,
                    price: price,
                    stock: stock
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: res.message || 'Product updated successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#editProductModal').addClass('hidden');
                    $('#products').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) $('#edit_name_error').text(errors.name[0]);
                        if (errors.price) $('#edit_price_error').text(errors.price[0]);
                        if (errors.stock) $('#edit_stock_error').text(errors.stock[0]);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong!'
                        });
                    }
                }
            });
        });

        // Open Import Modal
        $('#openImportModal').on('click', function() {
            $('#importModal').removeClass('hidden');
        });

        // Close Import Modal
        window.closeImportModal = function() {
            $('#importModal').addClass('hidden');
        };

        // Start Import
        window.startImport = function() {
            let fileInput = $('#csv_file')[0];
            if (!fileInput.files.length) {
                alert('Please select a CSV file');
                return;
            }
            let submitBtn = $('#importBtn');
            let btnText = submitBtn.find('.btn-text');
            let btnLoader = $('#importBtnLoader');

            submitBtn.prop('disabled', true).addClass('opacity-70 cursor-not-allowed');
            btnText.text('Saving...');
            btnLoader.removeClass('hidden');

            let formData = new FormData();
            formData.append('file', fileInput.files[0]);

            $.ajax({
                url: "{{ route('admin.products.import') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#progress').text('Import started...');
                    trackProgress(response.import_id);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Import failed');
                }
            });

        };

        // Track Progress
        // window.trackProgress = function(importId) {

        //     let interval = setInterval(function() {

        //         $.ajax({
        //             url: `/admin/products/import-status/${importId}`,
        //             type: 'GET',
        //             success: function(data) {
        //                 $('#progress').text('Processed Rows: ' + data.processed_rows);

        //                 if (data.status === 'completed') {
        //                     clearInterval(interval);
        //                     $('#progress').text('Import Completed ✅');
        //                 }
        //             }
        //         });

        //     }, 2000);
        // };

        // window.trackProgress = function(importId) {
        //     console.log('Tracking import:', importId); // Debug log

        //     let interval = setInterval(function() {
        //         $.ajax({
        //             url: `/admin/import-status/${importId}`,
        //             type: 'GET',
        //             headers: {
        //                 'X-Requested-With': 'XMLHttpRequest',
        //                 'Accept': 'application/json'
        //             },
        //             success: function(data) {
        //                 console.log('Progress data:', data); // Debug log

        //                 $('#progress').text('Processed Rows: ' + data.processed_rows);

        //                 if (data.status === 'completed') {
        //                     clearInterval(interval);
        //                     $('#progress').text('Import Completed ✅');

        //                     Swal.fire({
        //                         icon: 'success',
        //                         title: 'Import Completed!',
        //                         text: `Total rows processed: ${data.processed_rows}`,
        //                         timer: 3000
        //                     }).then(() => {
        //                         // Reload datatable or page
        //                         if (typeof $('#products').DataTable === 'function') {
        //                             $('#products').DataTable().ajax.reload();
        //                         }
        //                     });
        //                 }

        //                 if (data.status === 'failed') {
        //                     clearInterval(interval);
        //                     $('#progress').text('Import Failed ❌');

        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Import Failed',
        //                         text: 'Something went wrong during import'
        //                     });
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('AJAX Error:', {
        //                     status: xhr.status,
        //                     statusText: xhr.statusText,
        //                     responseText: xhr.responseText,
        //                     error: error
        //                 });

        //                 clearInterval(interval);
        //                 $('#progress').text('Error tracking import ❌');

        //                 // Show detailed error
        //                 let errorMsg = 'Error tracking import';
        //                 if (xhr.status === 404) {
        //                     errorMsg = 'Import status endpoint not found (404)';
        //                 } else if (xhr.status === 401) {
        //                     errorMsg = 'Unauthorized. Please login again.';
        //                 } else if (xhr.responseJSON?.message) {
        //                     errorMsg = xhr.responseJSON.message;
        //                 }

        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Tracking Error',
        //                     text: errorMsg
        //                 });
        //             }
        //         });
        //     }, 2000);
        // };


        // window.trackProgress = function(importId) {
        //     console.log('Tracking import:', importId);

        //     // Show progress section
        //     document.getElementById('progressSection').classList.remove('hidden');
        //     const importBtn = document.getElementById('importBtn');
        //     importBtn.disabled = true;
        //     importBtn.classList.add('opacity-50', 'cursor-not-allowed');

        //     let interval = setInterval(function() {
        //         // Using Fetch API instead of jQuery AJAX
        //         fetch(`/admin/import-status/${importId}`, {
        //                 method: 'GET',
        //                 headers: {
        //                     'X-Requested-With': 'XMLHttpRequest',
        //                     'Accept': 'application/json',
        //                     'Content-Type': 'application/json'
        //                 }
        //             })
        //             .then(response => {
        //                 if (!response.ok) {
        //                     throw new Error(`HTTP error! status: ${response.status}`);
        //                 }
        //                 return response.json();
        //             })
        //             .then(data => {
        //                 console.log('Progress data:', data);

        //                 // Update progress values
        //                 const processed = data.processed_rows || 0;
        //                 const total = data.total_rows || 0;
        //                 const skipped = data.skipped_rows || 0;
        //                 const remaining = total > 0 ? total - processed : 0;
        //                 const percentage = total > 0 ? Math.round((processed / total) * 100) : 0;

        //                 // Update UI elements
        //                 document.getElementById('totalRows').textContent = total;
        //                 document.getElementById('processedRows').textContent = processed;
        //                 document.getElementById('remainingRows').textContent = remaining;
        //                 document.getElementById('progressPercent').textContent = percentage + '%';
        //                 document.getElementById('progressBar').style.width = percentage + '%';

        //                 // Show skipped section if there are skipped rows
        //                 if (skipped > 0) {
        //                     document.getElementById('skippedSection').classList.remove('hidden');
        //                     document.getElementById('skippedRows').textContent = skipped;
        //                 }

        //                 // Update status text and color
        //                 const statusElement = document.getElementById('statusText');
        //                 if (data.status === 'running') {
        //                     statusElement.textContent = '⏳ Importing...';
        //                     statusElement.className = 'font-medium text-blue-600';
        //                     document.getElementById('progressBar').className =
        //                         'bg-blue-600 h-3 rounded-full transition-all duration-300';
        //                 }

        //                 // Handle completion
        //                 if (data.status === 'completed') {
        //                     clearInterval(interval);

        //                     statusElement.textContent = '✅ Completed';
        //                     statusElement.className = 'font-medium text-green-600';
        //                     document.getElementById('progressBar').className =
        //                         'bg-green-600 h-3 rounded-full transition-all duration-300';
        //                     document.getElementById('progressBar').style.width = '100%';

        //                     // Show completion message
        //                     const completionMsg = document.getElementById('completionMessage');
        //                     completionMsg.className =
        //                         'mt-4 p-3 rounded bg-green-100 border border-green-300 text-green-800';
        //                     completionMsg.innerHTML = `
    //             <div class="font-medium mb-1">✅ Import Completed Successfully!</div>
    //             <div class="text-sm">
    //                 Imported: ${processed} rows${skipped > 0 ? ` | Skipped: ${skipped} rows` : ''}
    //             </div>
    //         `;
        //                     completionMsg.classList.remove('hidden');

        //                     // Show success alert (if SweetAlert2 is available)
        //                     if (typeof Swal !== 'undefined') {
        //                         Swal.fire({
        //                             icon: 'success',
        //                             title: 'Import Completed!',
        //                             html: `
    //                     <p>Total rows processed: <strong>${processed}</strong></p>
    //                     ${skipped > 0 ? `<p>Skipped rows: <strong>${skipped}</strong></p>` : ''}
    //                 `,
        //                             timer: 3000,
        //                             showConfirmButton: true
        //                         }).then(() => {
        //                             reloadDataTable();
        //                             closeImportModal();
        //                         });
        //                     } else {
        //                         alert(`Import Completed! Processed: ${processed} rows`);
        //                         reloadDataTable();
        //                         setTimeout(() => closeImportModal(), 2000);
        //                     }
        //                 }

        //                 // Handle failure
        //                 if (data.status === 'failed') {
        //                     clearInterval(interval);

        //                     statusElement.textContent = '❌ Failed';
        //                     statusElement.className = 'font-medium text-red-600';
        //                     document.getElementById('progressBar').className =
        //                         'bg-red-600 h-3 rounded-full transition-all duration-300';

        //                     // Show error message
        //                     const completionMsg = document.getElementById('completionMessage');
        //                     completionMsg.className =
        //                         'mt-4 p-3 rounded bg-red-100 border border-red-300 text-red-800';
        //                     completionMsg.innerHTML = `
    //             <div class="font-medium mb-1">❌ Import Failed</div>
    //             <div class="text-sm">${data.error_message || 'Something went wrong during import'}</div>
    //         `;
        //                     completionMsg.classList.remove('hidden');

        //                     if (typeof Swal !== 'undefined') {
        //                         Swal.fire({
        //                             icon: 'error',
        //                             title: 'Import Failed',
        //                             text: data.error_message || 'Something went wrong during import'
        //                         });
        //                     } else {
        //                         alert('Import Failed: ' + (data.error_message || 'Something went wrong'));
        //                     }
        //                 }
        //             })
        //             .catch(error => {
        //                 console.error('Fetch Error:', error);
        //                 clearInterval(interval);

        //                 const statusElement = document.getElementById('statusText');
        //                 statusElement.textContent = '❌ Error';
        //                 statusElement.className = 'font-medium text-red-600';

        //                 let errorMsg = 'Error tracking import: ' + error.message;

        //                 if (typeof Swal !== 'undefined') {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Tracking Error',
        //                         text: errorMsg
        //                     });
        //                 } else {
        //                     alert(errorMsg);
        //                 }
        //             });
        //     }, 2000); // Check every 2 seconds
        // };

        // // Helper function to reload DataTable
        // function reloadDataTable() {
        //     // Try jQuery DataTable first
        //     if (typeof $ !== 'undefined' && typeof $('#products').DataTable === 'function') {
        //         $('#products').DataTable().ajax.reload();
        //     } else {
        //         // Otherwise reload the page
        //         window.location.reload();
        //     }
        // }

        // // Helper function to close modal
        // function closeImportModal() {
        //     document.getElementById('importModal').classList.add('hidden');
        //     document.getElementById('progressSection').classList.add('hidden');
        //     document.getElementById('completionMessage').classList.add('hidden');
        //     document.getElementById('csv_file').value = '';

        //     const importBtn = document.getElementById('importBtn');
        //     importBtn.disabled = false;
        //     importBtn.classList.remove('opacity-50', 'cursor-not-allowed');

        //     // Reset progress UI
        //     document.getElementById('progressBar').style.width = '0%';
        //     document.getElementById('progressPercent').textContent = '0%';
        //     document.getElementById('totalRows').textContent = '-';
        //     document.getElementById('processedRows').textContent = '0';
        //     document.getElementById('remainingRows').textContent = '-';
        //     document.getElementById('skippedRows').textContent = '0';
        //     document.getElementById('skippedSection').classList.add('hidden');
        // }

        // // Helper function to open modal
        // function openImportModal() {
        //     document.getElementById('importModal').classList.remove('hidden');
        // }

        // // Example startImport function (you'll need to implement your own)
        // function startImport() {
        //     const fileInput = document.getElementById('csv_file');
        //     const file = fileInput.files[0];

        //     if (!file) {
        //         alert('Please select a CSV file');
        //         return;
        //     }

        //     const formData = new FormData();
        //     formData.append('csv_file', file);

        //     // Send file to server
        //     fetch('/admin/import-products', {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        //                 'X-Requested-With': 'XMLHttpRequest'
        //             },
        //             body: formData
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.import_id) {
        //                 trackProgress(data.import_id);
        //             } else {
        //                 alert('Failed to start import');
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Import Error:', error);
        //             alert('Failed to start import: ' + error.message);
        //         });
        // }





        let importInterval = null;
        let currentImportId = null;

        /* ============================
           BUTTON STATE
        ============================ */
        function setButtonProcessing(isProcessing) {
            const $btn = $('#importBtn');

            if (isProcessing) {
                $btn.prop('disabled', true)
                    .html('⏳ Processing... Please wait')
                    .addClass('opacity-60 cursor-not-allowed');
            } else {
                $btn.prop('disabled', false)
                    .html('Start Import')
                    .removeClass('opacity-60 cursor-not-allowed');
            }
        }

        /* ============================
           STOP POLLING
        ============================ */
        function stopTracking() {
            if (importInterval) {
                clearInterval(importInterval);
                importInterval = null;
            }
            currentImportId = null;
            localStorage.removeItem('last_import_id');
            console.log('🛑 Import tracking stopped');
        }

        /* ============================
           TRACK IMPORT PROGRESS
        ============================ */
        function trackProgress(importId) {

            // ⛔ prevent duplicate interval
            if (importInterval && currentImportId === importId) {
                console.log('⚠️ Already tracking this import');
                return;
            }

            stopTracking(); // clear any old interval

            console.log('▶️ Tracking import:', importId);

            currentImportId = importId;
            localStorage.setItem('last_import_id', importId);

            $('#progressSection').removeClass('hidden');
            setButtonProcessing(true);

            importInterval = setInterval(function() {
                $.ajax({
                    url: `/admin/import-status/${importId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const processed = data.processed_rows || 0;
                        const total = data.total_rows || 0;
                        const skipped = data.skipped_rows || 0;
                        const remaining = total > 0 ? total - processed : 0;
                        const percentage = total > 0 ? Math.round((processed / total) * 100) : 0;

                        $('#totalRows').text(total);
                        $('#processedRows').text(processed);
                        $('#remainingRows').text(remaining);
                        $('#progressPercent').text(percentage + '%');
                        $('#progressBar').css('width', percentage + '%');

                        if (skipped > 0) {
                            $('#skippedSection').removeClass('hidden');
                            $('#skippedRows').text(skipped);
                        }

                        const $status = $('#statusText');

                        if (data.status === 'running') {
                            $status.text('⏳ Importing... Please do not refresh')
                                .attr('class', 'font-medium text-blue-600');
                            return;
                        }

                        if (data.status === 'completed') {
                            stopTracking();

                            $status.text('✅ Completed')
                                .attr('class', 'font-medium text-green-600');

                            $('#progressBar')
                                .css('width', '100%')
                                .attr('class', 'bg-green-600 h-3 rounded-full');

                            $('#completionMessage')
                                .removeClass('hidden')
                                .html(`
                            <div class="font-medium mb-1">✅ Import Completed</div>
                            <div class="text-sm">
                                Imported: ${processed}
                                ${skipped > 0 ? ` | Skipped: ${skipped}` : ''}
                            </div>
                        `);

                            setButtonProcessing(false);
                            reloadDataTable();
                            return;
                        }

                        if (data.status === 'failed') {
                            stopTracking();

                            $status.text('❌ Failed')
                                .attr('class', 'font-medium text-red-600');

                            setButtonProcessing(false);
                            alert(data.error_message || 'Import failed');
                        }
                    },
                    error: function() {
                        stopTracking();
                        setButtonProcessing(false);
                        alert('Error while tracking import');
                    }
                });
            }, 3000);
        }

        /* ============================
           PAGE LOAD / REFRESH HANDLING
        ============================ */
        // 🔹 NO automatic polling after refresh
        $(document).ready(function() {
            console.log('Page loaded. Import tracking will not resume automatically.');
        });

        /* ============================
           HELPERS
        ============================ */
        function reloadDataTable() {
            if ($.fn.DataTable) {
                $('#products').DataTable().ajax.reload(null, false);
            }
        }
    </script>
@endpush
