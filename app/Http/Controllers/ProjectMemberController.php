<?php

namespace ProjectManager\Http\Controllers;

use Illuminate\Http\Request;

use ProjectManager\Services\ProjectMemberService;
use ProjectManager\Http\Controllers\Controller;

class ProjectMemberController extends Controller
{

    protected $service;

    public function __construct(ProjectMemberService $service)
    {
        $this->service = $service;

        $this->middleware('check-project-owner', ['except' => ['index','show']]);
        $this->middleware('check-project-permission', ['except' => ['store','destroy']]);
    }

    public function index($id)
    {
        return $this->service->findMembers($id);
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->addMember($data);
    }

    public function show($id, $idMember)
    {
        return $this->service->findOneMember($id, $idMember);
    }

    public function update(Request $request, $id, $idMember)
    {
        $data = [
            'project_id' => $request->get('project_id'),
            'user_id' => $request->get('user_id')
        ];
        return $this->service->updateMember($data, $id, $idMember);
    }

    public function destroy($id, $memberId)
    {
        return $this->service->removeMember($id, $memberId);
    }

    public function check($id, $memberId)
    {
        return $this->service->isMember($id, $memberId);
    }
}
