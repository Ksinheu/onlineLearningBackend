<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg p-5 modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center text-primary" id="uploadModalLabel">បញ្ចូលលំហាត់</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('exercise.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
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

                        {{-- Exercise --}}
                        <div class="mb-3">
                            <label for="exercise_element">លំហាត់</label>
                            <textarea name="exercise_element" id="exercise_element" class="form-control" rows="3" required></textarea>
                        </div>

                        {{-- Images --}}
                        <div class="mb-3">
                            <label for="images">រូបភាពលំហាត់ (អាចបញ្ចូលច្រើន)</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> រក្សាទុក</button>
                        </div>
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
