<div class="modal fade" id="updateModal{{ $ex->id }}" tabindex="-1" aria-labelledby="uploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center text-primary" id="uploadModalLabel">
                    កែប្រែលំហាត់</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('exercise.update', $ex->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                     {{-- Course --}}
          <div class="mb-3">
            <label>ជ្រើសរើសមុខវិជ្ជា</label>
            <select
              name="course_id"
              class="form-control course-select"
              data-modal="{{ $ex->id }}"
              data-selected-course="{{ $ex->course_id }}"
              data-selected-lesson="{{ $ex->lesson_id }}"
            >
              <option value="">-- ជ្រើសរើសមុខវិជ្ជា --</option>
              @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                  {{ $ex->course_id == $course->id ? 'selected' : '' }}>
                  {{ $course->course_name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Lesson --}}
          <div class="mb-3">
            <label>មេរៀន</label>
            <select name="lesson_id" class="form-control lesson-select-{{ $ex->id }}">
              <option value="">-- ជ្រើសរើសមេរៀន --</option>
              {{-- Populated dynamically --}}
            </select>
          </div>

          {{-- Exercise --}}
          <div class="mb-3">
            <label>លំហាត់</label>
            <textarea name="exercise_element" class="form-control">{{ $ex->exercise_element }}</textarea>
          </div>

                    <!-- Existing Images -->
                    <div class="mb-3">
                        <label class="form-label">រូបភាព:</label><br>
                        @foreach ($ex->exerciseImage as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Exercise Image" width="100"
                                class="me-2 mb-2">
                        @endforeach
                    </div>

                    <!-- Upload New Images -->
                    <div class="mb-3">
                        <label for="images" class="form-label">បញ្ចូលរូបភាព</label>
                        <input type="file" name="images[]" multiple class="form-control">
                        @error('images.*')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pen"></i> កែប្រែ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
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
