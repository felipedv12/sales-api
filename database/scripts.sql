BEGIN;


CREATE TABLE IF NOT EXISTS public.product_type
(
    id serial,
    name character varying(100) NOT NULL,
    tax_percentage numeric(8, 3) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.product
(
    id serial,
    name character varying(100) NOT NULL,
    description character varying(255),
    price money,
    product_type_id integer NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.purchase
(
    id bigserial,
    purchased_amount numeric(18, 4) NOT NULL,
    total_product_value money NOT NULL,
    total_tax_value money NOT NULL,
    total_purchase_value money NOT NULL,
    product_id bigint NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.product
    ADD CONSTRAINT fk_product_type_product FOREIGN KEY (product_type_id)
    REFERENCES public.product_type (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;


ALTER TABLE IF EXISTS public.purchase
    ADD CONSTRAINT fk_product_purchase FOREIGN KEY (product_id)
    REFERENCES public.product (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;

END;