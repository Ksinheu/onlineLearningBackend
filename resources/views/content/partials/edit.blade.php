<div class="modal fade" id="editModal{{ $content->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $content->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">កែប្រែមាតិកា</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('content.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>មុខវិជ្ជា:</label>
                        <select name="course_id" class="form-control" required>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ $course->id == $content->course_id ? 'selected' : '' }}>
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>មេរៀន:</label>
                        <select name="lesson_id" class="form-control" required>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}"
                                    {{ $lesson->id == $content->lesson_id ? 'selected' : '' }}>
                                    {{ $lesson->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3"><label>រយៈពេល:</label><input type="text" name="session" class="form-control"
                            value="{{ $content->session }}" required></div>
                    <div class="mb-3"><label>លទ្ធផល:</label>
                        <textarea name="expect_result" class="form-control" required>{{ $content->expect_result }}</textarea>
                    </div>
                    <div class="mb-3"><label>មាតិកាមេរៀន:</label>
                        <textarea name="Lesson_content" class="form-control" required>{{ $content->Lesson_content }}</textarea>
                    </div>
                    {{-- Video URL --}}
                    <div class="mb-3">
                        <label for="video_url" class="form-label">វីដេអូ:</label>
                        <input type="file" name="video_url" id="video_url" class="form-control" accept="video/*">
                    </div>
                    <div class="mb-3"><label>សកម្មភាព:</label>
                        <textarea name="activity" class="form-control" required>{{ $content->activity }}</textarea>
                    </div>
                    <div class="mb-3"><label>ការវាយតម្លៃ:</label>
                        <textarea name="Evaluate" class="form-control" required>{{ $content->Evaluate }}</textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen"></i> កែប្រែ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const courseSelects = document.querySelectorAll('.course-select');

        courseSelects.forEach(select => {
            const modalId = select.dataset.modal;
            const lessonSelect = document.querySelector(`.lesson-select-${modalId}`);
            const selectedLesson = select.dataset.selectedLesson;

            function loadLessons(courseId, selectedLessonId = null) {
                lessonSelect.innerHTML = '<option>កំពុងផ្ទុក...</option>';

                fetch(`/lessons/by-course/${courseId}`)
                    .then(res => res.json())
                    .then(data => {
                        lessonSelect.innerHTML = '<option value="">-- ជ្រើសរើសមេរៀន --</option>';
                        data.forEach(lesson => {
                            const option = document.createElement('option');
                            option.value = lesson.id;
                            option.textContent = lesson.title;
                            if (lesson.id == selectedLessonId) {
                                option.selected = true;
                            }
                            lessonSelect.appendChild(option);
                        });
                    });
            }

            // Load on course change
            select.addEventListener('change', () => {
                loadLessons(select.value);
            });

            // Load on page if course already selected
            if (select.value) {
                loadLessons(select.value, selectedLesson);
            }
        });
    });
</script>
