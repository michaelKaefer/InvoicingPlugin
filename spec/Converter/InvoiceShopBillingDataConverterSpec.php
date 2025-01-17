<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\InvoicingPlugin\Converter;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ShopBillingDataInterface;
use Sylius\InvoicingPlugin\Converter\InvoiceShopBillingDataConverterInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceShopBillingDataInterface;

final class InvoiceShopBillingDataConverterSpec extends ObjectBehavior
{
    function it_implements_invoice_shop_billing_data_converter_interface(): void
    {
        $this->shouldImplement(InvoiceShopBillingDataConverterInterface::class);
    }

    function it_extracts_shop_billing_data_from_channel(
        ChannelInterface $channel,
        ShopBillingDataInterface $shopBillingData
    ): void {
        $channel->getShopBillingData()->willReturn($shopBillingData);

        $this->convert($channel)->shouldReturnAnInstanceOf(InvoiceShopBillingDataInterface::class);
    }
}
