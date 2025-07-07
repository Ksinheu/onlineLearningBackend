<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">បញ្ចូលមាតិកាថ្មី</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('content.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="course_id">មុខវិជ្ជា:</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">-- ជ្រើសរើស --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="lesson_id">មេរៀន:</label>
                        <select name="lesson_id" class="form-control" required>
                            <option value="">-- ជ្រើសរើស --</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3"><label>ចំនួនថ្ងៃ:</label><input type="text" name="session" class="form-control" required></div>
                    <div class="mb-3"><label>លទ្ធផល:</label><textarea name="expect_result" class="form-control" required></textarea></div>
                    <div class="mb-3"><label>មាតិកាមេរៀន:</label><textarea name="Lesson_content" class="form-control" required></textarea></div>
                    <div class="mb-3"><label>សកម្មភាព:</label><textarea name="activity" class="form-control" required></textarea></div>
                    <div class="mb-3"><label>ការវាយតម្លៃ:</label><textarea name="Evaluate" class="form-control" required></textarea></div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> រក្សាទុក</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
