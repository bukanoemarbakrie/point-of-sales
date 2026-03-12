<div class="row align-items-end">
    <div class="col-lg-4">
        <label for="date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" required>
    </div>
    <div class="col-lg-8 text-end">
        <button type="button" class="btn btn-success px-4 shadow-sm" id="btn-present-all">Mark All Present</button>
    </div>
</div>

<div class=" alert alert-info border-0 shadow-sm mb-4 mt-4">
    <strong>Note:</strong>
    <p>You can mark all students as present by clicking the button above.</p>
</div>

<div class="table-responsive shadow-sm mb-4">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%" class="text-center">
                    <div class="form-check d-flex justify-content-center mb-0">
                        <input type="checkbox" class="form-check-input" id="check-all" title="Check All">
                    </div>
                </th>
                <th width="20%">Student Name</th>
                <th width="15%">Status In</th>
                <th width="12%">Check In</th>
                <th width="15%">Status Out</th>
                <th width="12%">Check Out</th>
                <th width="21%">Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
            <tr class="student-row">
                <td class="text-center">
                    <div class="form-check d-flex justify-content-center m-0">
                        <input type="checkbox" class="form-check-input student-checkbox" name="attendances[{{ $index }}][student_id]" value="{{ $student->id }}" id="student{{ $student->id }}">
                    </div>
                </td>
                <td>
                    <label for="student{{ $student->id }}" class="mb-0 fw-semibold cursor-pointer d-block"> {{ $student->name }} </label>
                </td>
                <td>
                    <select class="form-select status-in" name="attendances[{{ $index }}][status_in]" id="" disabled>
                        <option value="">Select Status...</option>
                        <option value="hadir">Hadir</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="alpa">Alpa</option>
                    </select>
                </td>
                <td>
                    <input type="time" class="form-control check-in-time" name="attendances[{{ $index }}][check_in]" disabled>
                </td>
                <td>
                    <select class="form-select status-out" name="attendances[{{ $index }}][status_out]" id="" disabled>
                        <option value="">Select Status...</option>
                        <option value="pulang">Pulang</option>
                        <option value="bolos">Bolos</option>
                        <option value="izin pulang cepat">Izin Pulang Cepet</option>
                    </select>
                </td>
                <td>
                    <input type="time" class="form-control check-out-time" name="attendances[{{ $index }}][check_out]" disabled>
                </td>
                <td>
                    <input type="text" class="form-control note-input" name="attendances[{{ $index }}][note]" placeholder="Optional..." disabled>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">Data Student Note Found. <a href="{{ route('student.create') }}">Create Students</a>First</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .cursor-pointer {
        cursor: pointer
    }

    .student-row.selected {
        background-color: rgba(13, 110, 253, 0.05)
    }

    .form-check-input {
        width: 1.25em;
        height: 1.25em;
        cursor: pointer;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('check-all');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');
        const btnPresentAll = document.getElementById('btn-present-all');

        function toggleRowInput(checkbox) {
            const row = checkbox.closest('tr');
            const inputs = row.querySelectorAll('select, input:not([type="checkbox"])');

            if (checkbox.checked) {
                row.classList.add('selected');
                inputs.forEach(input => input.disabled = false)
            }else{
                row.classList.remove('selected')
                inputs.forEach(input =>{
                    input.disabled = true;

                    if (input.tagName === 'SELECT') {
                        input.value = '';
                    }else if (input.type === 'time') {
                        input.value = '';
                    }
                 })
             }
        }

        studentCheckboxes.forEach(cb => {
            toggleRowInput(cb);

            cb.addEventListener('change', function(){
                toggleRowInput(this);
                if(checkAll){
                    const checkCount = document.querySelectorAll('.student-checkbox:checked').length;
                    checkAll.checked = checkCount === studentCheckboxes.length && studentCheckboxes.length > 0;
                    checkAll.indeterminate = checkCount > 0 && checkCount <studentCheckboxes.length;
                }
            })
        })

        if(checkAll){
            checkAll.addEventListener('change', function(){
                const isChecked = this.checked;
                studentCheckboxes.forEach(cb => {
                    cb.checked = isChecked;
                    toggleRowInput(cb);
                })
            })
        }
    })
</script>
