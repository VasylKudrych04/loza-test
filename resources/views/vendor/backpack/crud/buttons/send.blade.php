<a
    href="{{ url($crud->route . '/' . $entry->getKey() . '/send') }}"
    class="btn btn-sm btn-link send-button"
    onclick="if (!window.confirm('Are you sure?')) { return false; }"
>
    <i class="la la-share"></i> Send
</a>

