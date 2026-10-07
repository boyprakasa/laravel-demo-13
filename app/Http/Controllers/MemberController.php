<?php

namespace App\Http\Controllers;

use App\DataTables\MembersDataTable;
use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index(MembersDataTable $dataTable)
    {
        return $dataTable->render('member.index');
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'string',
            'max:255',
            'email' => 'required',
            'email',
            'unique:members,email',
            'phone_number' => 'nullable',
            'string',
            'max:20',
            'address' => 'nullable',
            'string',
        ]);

        Member::create($validated);

        return redirect()->route('member.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        return view('member.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required',
            'string',
            'max:255',
            'email' => 'required',
            'email',
            'unique:members,email,' . $member->id,
            'phone_number' => 'nullable',
            'string',
            'max:20',
            'address' => 'nullable',
            'string',
        ]);

        $member->update($validated);

        return redirect()->route('member.index')
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('member.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
