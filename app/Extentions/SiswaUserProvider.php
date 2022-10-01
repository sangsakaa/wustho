<?php

namespace App\Extentions;

use App\Models\Siswa;
use Illuminate\Auth\EloquentUserProvider;

class SiswaUserProvider extends EloquentUserProvider
{
    /**
     * Get a new query builder for the model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newModelQuery($model = null)
    {
        $builder = is_null($model)
            ? $this->createModel()->newQuery()
            : $model->newQuery();

        $nisSiswa = Siswa::query()
            ->join('nis', 'nis.siswa_id', '=', 'siswa.id')
            ->select('siswa.id as siswa_id', 'nis.nis');
        $builder
            ->leftJoinSub($nisSiswa, 'nisSiswa', function ($query) {
                $query->on('nisSiswa.siswa_id', '=', 'users.siswa_id');
            })
            ->select('users.*', 'nisSiswa.nis');
        return $builder;
    }
}