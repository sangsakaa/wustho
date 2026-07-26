<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  public function toArray($request)
  {
    return [

      'id' => $this->id,

      'name' => $this->name,

      'email' => $this->email,

      'role' => $this->getRoleNames()->first(),

      'is_student' => !is_null($this->siswa_id),

      'is_teacher' => !is_null($this->guru_id),

      'student_id' => $this->siswa_id,

      'teacher_id' => $this->guru_id,

    ];
  }
}
