 <!-- Main Content -->
 <div class="container my-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-3">Tài liệu của tôi</h2>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="fas fa-plus me-2"></i>Upload tài liệu
                </button>
            </div>
        </div>

        <!-- Documents Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="documentsTable">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="40%">Tên tài liệu</th>
                                <th scope="col" width="15%">Định dạng</th>
                                <th scope="col" width="15%">Ngày tải lên</th>
                                <th scope="col" width="15%">Kích thước</th>
                                <th scope="col" width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf text-danger me-2 fs-4"></i>
                                        <div>
                                            <div class="fw-bold">Bài giảng Toán cao cấp - Chương 1</div>
                                            <div class="text-muted small">Môn: Toán cao cấp | Lớp: KHMT-K27</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-danger">PDF</span></td>
                                <td>15/03/2023</td>
                                <td>2.4 MB</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-word text-primary me-2 fs-4"></i>
                                        <div>
                                            <div class="fw-bold">Đề thi Lập trình cơ bản - Giữa kỳ</div>
                                            <div class="text-muted small">Môn: Lập trình cơ bản | Lớp: KTPM-K27</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">DOCX</span></td>
                                <td>10/04/2023</td>
                                <td>1.8 MB</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-powerpoint text-warning me-2 fs-4"></i>
                                        <div>
                                            <div class="fw-bold">Slide bài giảng Cơ sở dữ liệu</div>
                                            <div class="text-muted small">Môn: Cơ sở dữ liệu | Lớp: MMT-K27</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning text-dark">PPTX</span></td>
                                <td>05/05/2023</td>
                                <td>5.2 MB</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#viewModal">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Phân trang" class="mt-4">
                    <ul class="pagination justify-content-center" id="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-cloud-upload-alt me-2"></i>Tải lên tài liệu mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm">
                        <div class="mb-3">
                            <label for="documentName" class="form-label">Tên tài liệu</label>
                            <input type="text" class="form-control" id="documentName" required>
                        </div>
                        <div class="mb-3">
                            <label for="documentDescription" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="documentDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="documentCategory" class="form-label">Danh mục</label>
                            <select class="form-select" id="documentCategory">
                                <option value="">Chọn danh mục</option>
                                <option value="1">Bài giảng</option>
                                <option value="2">Đề thi</option>
                                <option value="3">Tài liệu tham khảo</option>
                                <option value="4">Bài tập</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentSubject" class="form-label">Môn học liên quan <span class="text-danger">*</span></label>
                            <select class="form-select" id="editDocumentSubject" required>
                                <option value="">Chọn môn học</option>
                                <option value="1">Toán cao cấp</option>
                                <option value="2">Lập trình cơ bản</option>
                                <option value="3">Cơ sở dữ liệu</option>
                                <option value="4">Trí tuệ nhân tạo</option>
                                <option value="5">Phát triển web</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentClass" class="form-label">Lớp học cụ thể <span class="text-danger">*</span></label>
                            <select class="form-select" id="editDocumentClass" required>
                                <option value="">Chọn lớp học</option>
                                <option value="1">KHMT-K27</option>
                                <option value="2">KTPM-K27</option>
                                <option value="3">MMT-K27</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="documentFile" class="form-label">Chọn file</label>
                            <input class="form-control" type="file" id="documentFile" required>
                        </div>
                    </form>
                    <div class="document-upload-preview d-none mt-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="fas fa-file-alt me-2"></i><span id="previewName"></span></h6>
                                <div class="small text-muted" id="previewInfo"></div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="uploadBtn">Tải lên</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Chỉnh sửa tài liệu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editDocumentId">
                        <div class="mb-3">
                            <label for="editDocumentName" class="form-label">Tên tài liệu</label>
                            <input type="text" class="form-control" id="editDocumentName" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentDescription" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="editDocumentDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentCategory" class="form-label">Danh mục</label>
                            <select class="form-select" id="editDocumentCategory">
                                <option value="">Chọn danh mục</option>
                                <option value="1">Bài giảng</option>
                                <option value="2">Đề thi</option>
                                <option value="3">Tài liệu tham khảo</option>
                                <option value="4">Bài tập</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentSubject" class="form-label">Môn học liên quan <span class="text-danger">*</span></label>
                            <select class="form-select" id="editDocumentSubject" required>
                                <option value="">Chọn môn học</option>
                                <option value="1">Toán cao cấp</option>
                                <option value="2">Lập trình cơ bản</option>
                                <option value="3">Cơ sở dữ liệu</option>
                                <option value="4">Trí tuệ nhân tạo</option>
                                <option value="5">Phát triển web</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentClass" class="form-label">Lớp học cụ thể <span class="text-danger">*</span></label>
                            <select class="form-select" id="editDocumentClass" required>
                                <option value="">Chọn lớp học</option>
                                <option value="1">KHMT-K27</option>
                                <option value="2">KTPM-K27</option>
                                <option value="3">MMT-K27</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File hiện tại</label>
                            <div class="d-flex align-items-center">
                                <span class="me-2" id="currentFileName"></span>
                                <span class="badge bg-primary" id="currentFileType"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDocumentFile" class="form-label">Thay thế file (không bắt buộc)</label>
                            <input class="form-control" type="file" id="editDocumentFile">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa tài liệu <strong id="deleteDocumentName"></strong>?</p>
                    <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Document Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDocumentTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div class="mb-2">
                                <span class="text-muted">Mô tả:</span>
                                <p id="viewDocumentDescription"></p>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Danh mục:</span>
                                <span class="ms-2" id="viewDocumentCategory"></span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Môn học:</span>
                                <span class="ms-2" id="viewDocumentSubject"></span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Lớp học:</span>
                                <span class="ms-2" id="viewDocumentClass"></span>
                            </div>
                            <div>
                                <span class="text-muted">Ngày tải lên:</span>
                                <span class="ms-2" id="viewDocumentDate"></span>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="#" class="btn btn-outline-primary me-2" id="viewDownloadBtn">
                                <i class="fas fa-download me-2"></i>Tải xuống
                            </a>

                        </div>
                    </div>
                    <!-- <div class="document-preview bg-light p-3 text-center">
                        <div id="documentPreviewContent"> -->
                            <!-- Nội dung xem trước sẽ được thêm bởi JavaScript -->
                        <!-- </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>