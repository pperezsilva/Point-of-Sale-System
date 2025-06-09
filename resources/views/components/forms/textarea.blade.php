@props([
    'labelText' => null,
    'id',
    'required' => false,
    'defaultValue' => null
])

<label for="{{$id}}" class="form-label">
    {{$labelText != null ? $labelText : ucfirst($id) }}:
    <span class="text-danger"> {{ $required ? '*' : '' }} </span>
</label>
<textarea 
    {{ $required ? 'required' : ''}} 
    rows="3"
    type="text"
    name="{{$id}}" 
    id="{{$id}}" 
    class="form-control">{{old($id, $defaultValue)}}</textarea>
@error($id)
<small class="text-danger">{{'*'.$message}}</small>
@enderror