- hosts : {{ $job->hosts }}
  sudo: {{ $job->sudo?"yes":"no" }}
  vars:
    pid: {{ $pid }}
@foreach($vars as $key => $value)
    {{ $key }}: {{ $value }}
@endforeach
  gather_facts: true
  roles :
@foreach($job->template->roles as $role)
    - {{ $role }}
@endforeach