<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\ClassesResource;
use App\Models\Classes;
use Gate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\StudentResource; // Add this line to import StudentResource
use App\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request) {
        Gate::authorize('acesso_alunos');
        $studentsQuery = Student::query();
        $this->applySearch($studentsQuery, $request->search);
        $students = StudentResource::collection(
            $studentsQuery->paginate(10)
        );

        return inertia('Students/Index', [
            'students' => $students,
            'search' => $request->search ?? '',
        ]);
    }

    protected function applySearch($query, $search) {
        return $query->where(function ($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%');
            $query->orWhere('email', 'like', '%'.$search.'%');
        });
    }

    public function create() {
        Gate::authorize('criar_alunos');
        $classes = ClassesResource::collection(Classes::all());
        return Inertia::render('Students/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        Gate::authorize('criar_alunos');
        Student::create($request->validated());
        return redirect()->route('students.index')->with('success', 'Aluno criado com Sucesso!');
    }

    public function edit(Student $student) {
        Gate::authorize('editar_alunos');
        $classes = ClassesResource::collection(Classes::all());
        return inertia('Students/Edit', [
            'classes' => $classes,
            'student' => StudentResource::make($student),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student) {
        Gate::authorize('editar_alunos');
        $student->update($request->validated());
        return redirect()->route('students.index')->with('success', 'Aluno atualizado com Sucesso!');
    }

    public function destroy(Student $student) {
        Gate::authorize('apagar_alunos');
        $student->delete();
        return redirect()->route('students.index');
    }
}
