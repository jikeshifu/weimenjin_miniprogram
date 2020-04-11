<?php

declare(strict_types=1);

/*
 * This file is part of the EasyWeChatComposer.
 *
 * (c) 张铭阳 <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChatComposer\Http;

class DelegationResponse extends Response
{
    /**
     * @return string
     */
    public function getBodyContents()
    {
        return $this->response->getBodyContents();
    }
}
