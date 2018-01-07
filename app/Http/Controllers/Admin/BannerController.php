<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\BannerDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateBannerRequest;
use App\Http\Requests\Admin\UpdateBannerRequest;
use App\Repositories\BannerRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class BannerController extends AppBaseController
{
    /** @var  BannerRepository */
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->middleware('auth');
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * Display a listing of the Banner.
     *
     * @param BannerDataTable $bannerDataTable
     * @return Response
     */
    public function index(BannerDataTable $bannerDataTable)
    {
        return $bannerDataTable->render('admin.banners.index');
    }

    /**
     * Show the form for creating a new Banner.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created Banner in storage.
     *
     * @param CreateBannerRequest $request
     *
     * @return Response
     */
    public function store(CreateBannerRequest $request)
    {
        $input = $request->all();

        $banner = $this->bannerRepository->create($input);

        Flash::success('Banner saved successfully.');

        return redirect(route('admin.banners.index'));
    }

    /**
     * Display the specified Banner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('admin.banners.index'));
        }

        return view('admin.banners.show')->with('banner', $banner);
    }

    /**
     * Show the form for editing the specified Banner.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('admin.banners.index'));
        }

        return view('admin.banners.edit')->with('banner', $banner);
    }

    /**
     * Update the specified Banner in storage.
     *
     * @param  int              $id
     * @param UpdateBannerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBannerRequest $request)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('admin.banners.index'));
        }

        $banner = $this->bannerRepository->update($request->all(), $id);

        Flash::success('Banner updated successfully.');

        return redirect(route('admin.banners.index'));
    }

    /**
     * Remove the specified Banner from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $banner = $this->bannerRepository->findWithoutFail($id);

        if (empty($banner)) {
            Flash::error('Banner not found');

            return redirect(route('admin.banners.index'));
        }

        $this->bannerRepository->delete($id);

        Flash::success('Banner deleted successfully.');

        return redirect(route('admin.banners.index'));
    }
}
