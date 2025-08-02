<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">បញ្ចូលមាតិកាថ្មី</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Course --}}
                    <div class="mb-3">
                        <label for="create-course">ជ្រើសរើសមុខវិជ្ជា</label>
                        <select name="course_id" id="create-course" class="form-control"
                            onchange="loadLessonsForCreate(this.value)" required>
                            <option value="">-- ជ្រើសរើសមុខវិជ្ជា --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lessons --}}
                    <div class="mb-3">
                        <label for="create-lesson">មេរៀន</label>
                        <select name="lesson_id" id="create-lesson" class="form-control" required>
                            <option value="">-- ជ្រើសរើសមេរៀន --</option>
                            {{-- Loaded dynamically --}}
                        </select>
                    </div>

                    <div class="mb-3"><label>រយៈពេល:</label><input type="text" name="session"
                            class="form-control" required></div>
                    <div class="mb-3"><label>លទ្ធផល:</label>
                        <textarea name="expect_result" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3"><label>មាតិកាមេរៀន:</label>
                        <textarea name="Lesson_content" class="form-control" required></textarea>
                    </div>
                    <!-- Video Upload -->
                    <div class="mb-3">
                        <label for="video_url" class="form-label">បញ្ចូលវីដេអូ (MP4/MOV/AVI/FLV):</label>
                        <input type="file" name="video_url" id="video_url" class="form-control" accept="video/*"
                            required>
                        <small class="form-text text-muted">អតិបរមា 100MB</small>
                    </div>
                    <div class="mb-3"><label>សកម្មភាពសិស្ស:</label>
                        <textarea name="activity" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3"><label>ការវាយតម្លៃ:</label>
                        <textarea name="Evaluate" class="form-control" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i>
                            រក្សាទុក</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function loadLessonsForCreate(courseId) {
        const lessonSelect = document.getElementById('create-lesson');
        lessonSelect.innerHTML = '<option>កំពុងផ្ទុក...</option>';

        fetch(`/lessons/by-course/${courseId}`)
            .then(res => res.json())
            .then(data => {
                lessonSelect.innerHTML = '<option value="">-- ជ្រើសរើសមេរៀន --</option>';
                data.forEach(lesson => {
                    const option = document.createElement('option');
                    option.value = lesson.id;
                    option.textContent = lesson.title;
                    lessonSelect.appendChild(option);
                });
            });
    }
</script>
